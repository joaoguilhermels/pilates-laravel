<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SaaS Plan Features Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the feature definitions for each SaaS plan.
    | Features are organized by plan slug and include both limits and
    | boolean feature flags.
    |
    */

    'profissional' => [
        // Resource Limits
        'max_clients' => 100,
        'max_users' => 1, // Only the professional themselves
        'max_locations' => null, // Can work anywhere
        'max_rooms' => null, // Can work in any room
        'max_plans' => 10, // Limited plan templates
        'max_schedules_per_day' => 20,
        'max_monthly_revenue_tracking' => 50000, // R$ 50k/month tracking
        
        // Core Features (Always Available)
        'personal_calendar' => true,
        'client_management' => true,
        'basic_scheduling' => true,
        'basic_reports' => true,
        'online_booking' => true,
        'mobile_app' => true,
        'email_support' => true,
        'financial_tracking' => true,
        'multi_location_work' => true,
        
        // Advanced Features (Disabled)
        'team_management' => false,
        'advanced_reports' => false,
        'executive_dashboard' => false,
        'multi_location_management' => false,
        'priority_support' => false,
        'automated_billing' => false,
        'custom_branding' => false,
        'api_access' => false,
        'backup_restore' => false,
        'bulk_operations' => false,
        'advanced_analytics' => false,
        'membership_plans' => false,
        'payment_integration' => false,
        'franchise_support' => false,
        'white_label' => false,
        'sms_notifications' => false,
        'advanced_scheduling' => false,
        'inventory_management' => false,
        'staff_payroll' => false,
        'tax_reports' => false,
    ],

    'estudio' => [
        // Resource Limits (Unlimited)
        'max_clients' => null,
        'max_users' => null,
        'max_locations' => null,
        'max_rooms' => null,
        'max_plans' => null,
        'max_schedules_per_day' => null,
        'max_monthly_revenue_tracking' => null,
        
        // All Features Enabled
        'personal_calendar' => true,
        'client_management' => true,
        'basic_scheduling' => true,
        'basic_reports' => true,
        'online_booking' => true,
        'mobile_app' => true,
        'email_support' => true,
        'financial_tracking' => true,
        'multi_location_work' => true,
        
        // Advanced Features (Studio Exclusive)
        'team_management' => true,
        'advanced_reports' => true,
        'executive_dashboard' => true,
        'multi_location_management' => true,
        'priority_support' => true,
        'automated_billing' => true,
        'custom_branding' => true,
        'api_access' => true,
        'backup_restore' => true,
        'bulk_operations' => true,
        'advanced_analytics' => true,
        'membership_plans' => true,
        'payment_integration' => true,
        'franchise_support' => true,
        'white_label' => false, // Future feature
        'sms_notifications' => true,
        'advanced_scheduling' => true,
        'inventory_management' => true,
        'staff_payroll' => true,
        'tax_reports' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Feature Categories
    |--------------------------------------------------------------------------
    |
    | Groups features by category for better organization and UI display
    |
    */
    'categories' => [
        'core' => [
            'name' => 'Funcionalidades Essenciais',
            'features' => [
                'personal_calendar',
                'client_management', 
                'basic_scheduling',
                'basic_reports',
                'financial_tracking'
            ]
        ],
        'business' => [
            'name' => 'Gestão de Negócio',
            'features' => [
                'team_management',
                'multi_location_management',
                'advanced_reports',
                'executive_dashboard',
                'automated_billing'
            ]
        ],
        'advanced' => [
            'name' => 'Recursos Avançados',
            'features' => [
                'api_access',
                'custom_branding',
                'backup_restore',
                'bulk_operations',
                'advanced_analytics'
            ]
        ],
        'integration' => [
            'name' => 'Integrações',
            'features' => [
                'payment_integration',
                'sms_notifications',
                'online_booking',
                'mobile_app'
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Upgrade Messages
    |--------------------------------------------------------------------------
    |
    | Messages shown when users try to access premium features
    |
    */
    'upgrade_messages' => [
        'profissional' => [
            'default' => 'Esta funcionalidade está disponível no plano Estúdio. Faça upgrade para desbloquear!',
            'team_management' => 'Gerencie sua equipe completa com o plano Estúdio. Upgrade agora!',
            'advanced_reports' => 'Relatórios executivos estão disponíveis no plano Estúdio.',
            'multi_location_management' => 'Gerencie múltiplas unidades com o plano Estúdio.',
            'priority_support' => 'Suporte prioritário está incluído no plano Estúdio.',
        ]
    ]
];
