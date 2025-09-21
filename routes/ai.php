<?php

use Laravel\Mcp\Server\Facades\Mcp;

// Register the Onboarding MCP Server
Mcp::local('onboarding', \App\Mcp\Servers\OnboardingServer::class); // Start with ./artisan mcp:start onboarding
Mcp::web('onboarding-web', \App\Mcp\Servers\OnboardingServer::class); // Available at /mcp/onboarding-web

// Example servers (commented out)
// Mcp::web('demo', \App\Mcp\Servers\PublicServer::class); // Available at /mcp/demo
// Mcp::local('demo', \App\Mcp\Servers\LocalServer::class); // Start with ./artisan mcp:start demo
