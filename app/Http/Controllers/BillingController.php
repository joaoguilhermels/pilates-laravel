<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\StripeService;
use App\Models\SaasPlans;

class BillingController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
        $this->middleware('auth');
    }

    /**
     * Show billing dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $subscriptionInfo = $this->stripeService->getSubscriptionInfo($user);
        $currentPlan = $user->saasPlans;
        $availablePlans = SaasPlans::all();

        return view('billing.index', compact('user', 'subscriptionInfo', 'currentPlan', 'availablePlans'));
    }

    /**
     * Show subscription plans for upgrade/downgrade
     */
    public function plans()
    {
        $user = Auth::user();
        $currentPlan = $user->saasPlans;
        $plans = SaasPlans::active()->get();

        return view('billing.plans', compact('user', 'currentPlan', 'plans'));
    }

    /**
     * Create checkout session for new subscription or plan change
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:saas_plans,id',
            'billing_cycle' => 'required|in:monthly,yearly',
        ]);

        $user = Auth::user();
        $plan = SaasPlans::findOrFail($request->plan_id);

        try {
            // Check if user needs to complete billing information
            if ($user->needsBillingInfo()) {
                return redirect()->route('billing.info')
                    ->with('warning', 'Complete suas informações de cobrança antes de prosseguir.');
            }

            // If user already has a subscription, change the plan instead
            if ($user->stripe_subscription_id && $user->hasActiveStripeSubscription()) {
                $subscription = $this->stripeService->changeSubscriptionPlan($user, $plan, $request->billing_cycle);
                
                return redirect()->route('billing.index')
                    ->with('success', 'Plano alterado com sucesso! As mudanças entrarão em vigor no próximo ciclo de cobrança.');
            }

            // Create new checkout session
            $session = $this->stripeService->createCheckoutSession($user, $plan, $request->billing_cycle);

            return redirect($session->url);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao processar pagamento: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful checkout
     */
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        if (!$sessionId) {
            return redirect()->route('billing.index')
                ->with('error', 'Sessão de pagamento não encontrada.');
        }

        try {
            $user = $this->stripeService->handleSuccessfulCheckout($sessionId);
            
            return redirect()->route('billing.index')
                ->with('success', '🎉 Pagamento processado com sucesso! Sua assinatura está ativa.');
        } catch (\Exception $e) {
            return redirect()->route('billing.index')
                ->with('error', 'Erro ao processar pagamento: ' . $e->getMessage());
        }
    }

    /**
     * Handle canceled checkout
     */
    public function cancel()
    {
        return redirect()->route('billing.index')
            ->with('info', 'Pagamento cancelado. Você pode tentar novamente quando quiser.');
    }

    /**
     * Show billing information form
     */
    public function showBillingInfo()
    {
        $user = Auth::user();
        return view('billing.info', compact('user'));
    }

    /**
     * Update billing information
     */
    public function updateBillingInfo(Request $request)
    {
        $request->validate([
            'tax_id' => 'required|string|min:11|max:18',
            'tax_id_type' => 'required|in:cpf,cnpj',
            'company_name' => 'nullable|string|max:255',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'address_city' => 'required|string|max:100',
            'address_state' => 'required|string|max:2',
            'address_postal_code' => 'required|string|max:10',
        ]);

        $user = Auth::user();
        
        // Validate CPF/CNPJ format
        $taxId = preg_replace('/[^0-9]/', '', $request->tax_id);
        
        if ($request->tax_id_type === 'cpf' && strlen($taxId) !== 11) {
            return redirect()->back()
                ->withErrors(['tax_id' => 'CPF deve ter 11 dígitos.'])
                ->withInput();
        }
        
        if ($request->tax_id_type === 'cnpj' && strlen($taxId) !== 14) {
            return redirect()->back()
                ->withErrors(['tax_id' => 'CNPJ deve ter 14 dígitos.'])
                ->withInput();
        }

        $user->update([
            'tax_id' => $taxId,
            'tax_id_type' => $request->tax_id_type,
            'company_name' => $request->company_name,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'address_city' => $request->address_city,
            'address_state' => strtoupper($request->address_state),
            'address_postal_code' => preg_replace('/[^0-9]/', '', $request->address_postal_code),
            'address_country' => 'BR',
        ]);

        // Update Stripe customer if exists
        if ($user->stripe_customer_id) {
            try {
                $stripe = app('stripe');
                $stripe->customers->update($user->stripe_customer_id, [
                    'address' => $user->getStripeAddress(),
                    'tax_id_data' => $user->getStripeTaxIdData(),
                ]);
            } catch (\Exception $e) {
                // Log error but don't fail the request
                \Log::error('Error updating Stripe customer: ' . $e->getMessage());
            }
        }

        return redirect()->route('billing.index')
            ->with('success', 'Informações de cobrança atualizadas com sucesso!');
    }

    /**
     * Open Stripe billing portal
     */
    public function portal()
    {
        $user = Auth::user();
        
        if (!$user->stripe_customer_id) {
            return redirect()->route('billing.index')
                ->with('error', 'Você precisa ter uma assinatura ativa para acessar o portal de cobrança.');
        }

        try {
            $session = $this->stripeService->createBillingPortalSession($user);
            return redirect($session->url);
        } catch (\Exception $e) {
            return redirect()->route('billing.index')
                ->with('error', 'Erro ao acessar portal de cobrança: ' . $e->getMessage());
        }
    }

    /**
     * Cancel subscription
     */
    public function cancelSubscription(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->stripe_subscription_id) {
            return redirect()->route('billing.index')
                ->with('error', 'Você não possui uma assinatura ativa.');
        }

        try {
            $atPeriodEnd = $request->boolean('at_period_end', true);
            $this->stripeService->cancelSubscription($user, $atPeriodEnd);
            
            $message = $atPeriodEnd 
                ? 'Assinatura será cancelada no final do período atual.'
                : 'Assinatura cancelada imediatamente.';
                
            return redirect()->route('billing.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('billing.index')
                ->with('error', 'Erro ao cancelar assinatura: ' . $e->getMessage());
        }
    }

    /**
     * Resume canceled subscription
     */
    public function resumeSubscription()
    {
        $user = Auth::user();
        
        if (!$user->stripe_subscription_id || !$user->stripe_subscription_cancel_at_period_end) {
            return redirect()->route('billing.index')
                ->with('error', 'Não há assinatura cancelada para reativar.');
        }

        try {
            $this->stripeService->resumeSubscription($user);
            
            return redirect()->route('billing.index')
                ->with('success', 'Assinatura reativada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('billing.index')
                ->with('error', 'Erro ao reativar assinatura: ' . $e->getMessage());
        }
    }
}
