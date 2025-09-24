<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FeatureService;
use App\Models\SaasPlans;

class UpgradeController extends Controller
{
    /**
     * Show the upgrade page
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $currentPlan = $user->saasPlans;
        $availablePlans = SaasPlans::active()->get();
        
        // Get feature comparison
        $comparison = FeatureService::getPlanComparison();
        
        // Get user's current usage
        $usage = $user->getResourceUsageSummary();
        
        // Get the feature that triggered the upgrade (if any)
        $blockedFeature = session('feature');
        $blockedResource = session('resource');
        
        return view('upgrade.index', compact(
            'user',
            'currentPlan', 
            'availablePlans',
            'comparison',
            'usage',
            'blockedFeature',
            'blockedResource'
        ));
    }

    /**
     * Handle upgrade request
     */
    public function upgrade(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:saas_plans,id',
            'billing_cycle' => 'required|in:monthly,yearly'
        ]);

        $user = $request->user();
        $newPlan = SaasPlans::find($request->plan_id);
        
        // TODO: Integrate with Stripe for payment processing
        // For now, we'll just update the plan (trial extension)
        
        $user->update([
            'saas_plan_id' => $newPlan->id,
            'billing_cycle' => $request->billing_cycle,
            'trial_ends_at' => now()->addDays($newPlan->trial_days), // Extend trial
        ]);

        // Clear feature cache
        $user->clearFeatureCache();

        // Update role based on new plan
        if ($newPlan->slug === 'profissional') {
            $user->syncRoles(['studio_professional']);
        } else {
            $user->syncRoles(['studio_owner']);
        }

        return redirect()->route('home')
            ->with('success', "Parabéns! Você fez upgrade para o plano {$newPlan->name}. Aproveite todas as novas funcionalidades!");
    }
}
