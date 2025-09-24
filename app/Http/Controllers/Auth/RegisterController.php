<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SaasPlans;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'studio_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'saas_plan_id' => ['required', 'exists:saas_plans,id'],
            'billing_cycle' => ['required', 'in:monthly,yearly'],
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
