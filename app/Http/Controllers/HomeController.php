<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Professional;
use App\Models\Room;
use App\Models\ClassType;
use App\Models\Plan;
use App\Models\Schedule;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Check if this is a new user who needs onboarding
        $onboardingStatus = $this->checkOnboardingStatus();
        
        // Get dashboard statistics
        $stats = $this->getDashboardStats();
        
        // Get recent activity
        $recentActivity = $this->getRecentActivity();
        
        return view('home', compact('onboardingStatus', 'stats', 'recentActivity'));
    }

    /**
     * Check onboarding status and determine what setup steps are needed
     */
    public function checkOnboardingStatus()
    {
        $status = [
            'needsOnboarding' => false,
            'completedSteps' => [],
            'nextSteps' => [],
            'progress' => 0
        ];

        $steps = [
            'professionals' => [
                'title' => 'Add Your First Instructor',
                'description' => 'Add professionals who will teach classes',
                'completed' => Professional::count() > 0,
                'route' => 'professionals.create',
                'icon' => 'users',
                'priority' => 1
            ],
            'rooms' => [
                'title' => 'Set Up Studio Rooms',
                'description' => 'Define the spaces where classes will be held',
                'completed' => Room::count() > 0,
                'route' => 'rooms.create',
                'icon' => 'home',
                'priority' => 2
            ],
            'class_types' => [
                'title' => 'Create Class Types',
                'description' => 'Define the types of classes you offer',
                'completed' => ClassType::count() > 0,
                'route' => 'classes.create',
                'icon' => 'academic-cap',
                'priority' => 3
            ],
            'plans' => [
                'title' => 'Set Up Pricing Plans',
                'description' => 'Create subscription plans for your clients',
                'completed' => Plan::count() > 0,
                'route' => 'plans.create',
                'icon' => 'currency-dollar',
                'priority' => 4
            ],
            'clients' => [
                'title' => 'Add Your First Client',
                'description' => 'Start building your client base',
                'completed' => Client::count() > 0,
                'route' => 'clients.create',
                'icon' => 'user-group',
                'priority' => 5
            ],
            'schedules' => [
                'title' => 'Schedule Your First Class',
                'description' => 'Create your first class booking',
                'completed' => Schedule::count() > 0,
                'route' => 'schedules.create',
                'icon' => 'calendar',
                'priority' => 6
            ]
        ];

        $completedCount = 0;
        foreach ($steps as $key => $step) {
            if ($step['completed']) {
                $status['completedSteps'][] = $key;
                $completedCount++;
            } else {
                // Add required fields for the onboarding component
                $stepWithExtras = array_merge($step, [
                    'key' => $key,
                    'url' => route($step['route']),
                    'action' => $this->getActionText($step['title'])
                ]);
                $status['nextSteps'][] = $stepWithExtras;
            }
        }

        // Sort next steps by priority
        usort($status['nextSteps'], function($a, $b) {
            return $a['priority'] - $b['priority'];
        });

        $status['progress'] = round(($completedCount / count($steps)) * 100);
        $status['needsOnboarding'] = $completedCount < count($steps);
        $status['isNewUser'] = $completedCount === 0;
        $status['totalSteps'] = count($steps);
        $status['completedCount'] = $completedCount;

        return $status;
    }

    /**
     * Get dashboard statistics
     */
    private function getDashboardStats()
    {
        return [
            'clients' => Client::count(),
            'professionals' => Professional::count(),
            'rooms' => Room::count(),
            'class_types' => ClassType::count(),
            'plans' => Plan::count(),
            'schedules' => Schedule::count(),
            'upcoming_schedules' => Schedule::where('start_at', '>=', now())->count(),
            'today_schedules' => Schedule::whereDate('start_at', today())->count()
        ];
    }

    /**
     * Get recent activity for the dashboard
     */
    private function getRecentActivity()
    {
        $recentSchedules = Schedule::with(['client', 'professional', 'classType'])
            ->where('start_at', '>=', now())
            ->orderBy('start_at', 'asc')
            ->limit(5)
            ->get();

        $recentClients = Client::orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return [
            'upcoming_schedules' => $recentSchedules,
            'recent_clients' => $recentClients
        ];
    }

    /**
     * Mark onboarding step as completed
     */
    public function completeOnboardingStep(Request $request)
    {
        $step = $request->input('step');
        
        // Here you could store user preferences or onboarding progress
        // For now, we'll just return success as the completion is determined by data existence
        
        return response()->json(['success' => true]);
    }

    /**
     * Skip onboarding (for experienced users)
     */
    public function skipOnboarding()
    {
        // Mark onboarding as completed for this user
        auth()->user()->update(['onboarding_completed' => true]);
        
        // Clear onboarding session
        session()->forget('onboarding_active');
        
        return response()->json(['success' => true]);
    }

    public function startOnboarding()
    {
        // Set onboarding as active in session
        session(['onboarding_active' => true]);
        
        return response()->json(['success' => true]);
    }

    /**
     * Generate action text from step title
     */
    public function getActionText($title)
    {
        // Convert titles to action text
        $actionMap = [
            'Add Your First Instructor' => 'Add Instructor',
            'Set Up Studio Rooms' => 'Add Room',
            'Create Class Types' => 'Add Class Type',
            'Set Up Pricing Plans' => 'Add Plan',
            'Add Your First Client' => 'Add Client',
            'Schedule Your First Class' => 'Add Schedule'
        ];

        return $actionMap[$title] ?? 'Start Setup';
    }
}
