<?php

namespace App\Mcp\Servers;

use Laravel\Mcp\Server;
use App\Mcp\Resources\OnboardingStatus;
use App\Mcp\Tools\OnboardingTester;

class OnboardingServer extends Server
{
    public string $serverName = 'Pilates Studio Onboarding Server';

    public string $serverVersion = '1.0.0';

    public string $instructions = 'This MCP server provides access to the Pilates Studio Management System onboarding functionality. It can check onboarding status, test onboarding wizard functionality, and provide context about the user onboarding flow.';

    public array $tools = [
        OnboardingTester::class,
    ];

    public array $resources = [
        OnboardingStatus::class,
    ];

    public array $prompts = [
        // Future: OnboardingPrompts for AI-assisted onboarding
    ];
}
