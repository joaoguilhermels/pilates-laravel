<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SaasPlans;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Rules\NotBlacklistedEmail;
use App\Rules\BrazilianPhone;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('throttle:5,60')->only(['register']); // 5 attempts per hour
    }

    /**
     * Show the registration form with plan selection.
     */
    public function showRegistrationForm()
    {
        $plans = SaasPlans::active()->get();
        return view('auth.register', compact('plans'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', new NotBlacklistedEmail],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            'studio_name' => ['required', 'string', 'max:255', 'min:2'],
            'phone' => ['nullable', 'string', new BrazilianPhone],
            'saas_plan_id' => ['required', 'exists:saas_plans,id'],
            'billing_cycle' => ['required', 'in:monthly,yearly'],
        ], [
            'name.regex' => 'O nome deve conter apenas letras e espaços.',
            'email.unique' => 'Este email já está em uso.',
            'password.regex' => 'A senha deve conter pelo menos uma letra minúscula, uma maiúscula e um número.',
            'studio_name.min' => 'O nome do estúdio deve ter pelo menos 2 caracteres.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $plan = SaasPlans::find($data['saas_plan_id']);
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'studio_name' => $data['studio_name'],
            'phone' => $data['phone'] ?? null,
            'saas_plan_id' => $data['saas_plan_id'],
            'billing_cycle' => $data['billing_cycle'],
            'trial_ends_at' => now()->addDays($plan->trial_days),
            'is_trial' => true,
            'is_active' => true,
            'onboarding_completed' => false,
        ]);

        // Assign role based on selected plan
        if ($plan->slug === 'profissional') {
            $user->assignRole('studio_professional');
        } else {
            $user->assignRole('studio_owner');
        }

        return $user;
    }
}
