<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SecurityMiddleware
{
    /**
     * Suspicious patterns to detect
     */
    protected $suspiciousPatterns = [
        'sql_injection' => [
            '/(\bunion\b.*\bselect\b)|(\bselect\b.*\bunion\b)/i',
            '/(\bor\b.*\b1\s*=\s*1\b)|(\b1\s*=\s*1\b.*\bor\b)/i',
            '/(\bdrop\b.*\btable\b)|(\btable\b.*\bdrop\b)/i',
            '/(\binsert\b.*\binto\b)|(\binto\b.*\binsert\b)/i',
            '/(\bdelete\b.*\bfrom\b)|(\bfrom\b.*\bdelete\b)/i',
        ],
        'xss' => [
            '/<script[^>]*>.*?<\/script>/i',
            '/javascript:/i',
            '/on\w+\s*=/i',
            '/<iframe[^>]*>.*?<\/iframe>/i',
        ],
        'path_traversal' => [
            '/\.\.\//',
            '/\.\.\\\\/',
            '/\.\.\%2f/i',
            '/\.\.\%5c/i',
        ],
        'command_injection' => [
            '/;\s*(rm|del|format|shutdown)/i',
            '/\|\s*(cat|type|more|less)/i',
            '/`[^`]*`/',
            '/\$\([^)]*\)/',
        ]
    ];

    /**
     * Blocked user agents
     */
    protected $blockedUserAgents = [
        'sqlmap',
        'nikto',
        'nmap',
        'masscan',
        'zgrab',
        'python-requests',
        'curl/7', // Block basic curl requests
        'wget',
        'libwww-perl',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check for blocked user agents
        if ($this->isBlockedUserAgent($request)) {
            $this->logSecurityEvent('blocked_user_agent', $request);
            return response('Forbidden', 403);
        }

        // Check for suspicious patterns in request data
        if ($this->hasSuspiciousPatterns($request)) {
            $this->logSecurityEvent('suspicious_pattern', $request);
            return response('Bad Request', 400);
        }

        // Check for excessive requests from same IP
        if ($this->isRateLimited($request)) {
            $this->logSecurityEvent('rate_limit_exceeded', $request);
            return response('Too Many Requests', 429);
        }

        // Check for suspicious file uploads
        if ($this->hasSuspiciousUploads($request)) {
            $this->logSecurityEvent('suspicious_upload', $request);
            return response('Forbidden', 403);
        }

        return $next($request);
    }

    /**
     * Check if user agent is blocked
     */
    protected function isBlockedUserAgent(Request $request): bool
    {
        $userAgent = strtolower($request->userAgent() ?? '');
        
        foreach ($this->blockedUserAgents as $blocked) {
            if (str_contains($userAgent, strtolower($blocked))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check for suspicious patterns in request
     */
    protected function hasSuspiciousPatterns(Request $request): bool
    {
        $allInput = array_merge(
            $request->all(),
            [$request->getRequestUri()],
            $request->headers->all()
        );

        $inputString = json_encode($allInput);

        foreach ($this->suspiciousPatterns as $category => $patterns) {
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $inputString)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if IP is rate limited
     */
    protected function isRateLimited(Request $request): bool
    {
        $ip = $request->ip();
        $key = "security_rate_limit:{$ip}";
        
        $attempts = Cache::get($key, 0);
        
        if ($attempts >= 100) { // 100 requests per minute
            return true;
        }

        Cache::put($key, $attempts + 1, 60); // 1 minute window
        
        return false;
    }

    /**
     * Check for suspicious file uploads
     */
    protected function hasSuspiciousUploads(Request $request): bool
    {
        if (!$request->hasFile('file')) {
            return false;
        }

        $dangerousExtensions = [
            'php', 'php3', 'php4', 'php5', 'phtml',
            'exe', 'bat', 'cmd', 'com', 'scr',
            'js', 'jar', 'vbs', 'wsf', 'asp',
            'aspx', 'jsp', 'pl', 'py', 'rb',
            'sh', 'bash', 'ps1'
        ];

        foreach ($request->allFiles() as $files) {
            if (!is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {
                $extension = strtolower($file->getClientOriginalExtension());
                if (in_array($extension, $dangerousExtensions)) {
                    return true;
                }

                // Check file content for PHP tags
                $content = file_get_contents($file->getPathname());
                if (str_contains($content, '<?php') || str_contains($content, '<?=')) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Log security events
     */
    protected function logSecurityEvent(string $type, Request $request): void
    {
        $data = [
            'type' => $type,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'input' => $request->except(['password', 'password_confirmation']),
            'timestamp' => now()->toISOString(),
        ];

        Log::channel('security')->warning("Security event: {$type}", $data);

        // Also store in cache for monitoring
        $key = "security_events:" . date('Y-m-d-H');
        $events = Cache::get($key, []);
        $events[] = $data;
        Cache::put($key, $events, 3600); // Store for 1 hour
    }
}
