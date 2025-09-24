<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SecurityMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'security:monitor {--hours=24 : Number of hours to analyze}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor security events and generate reports';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hours = $this->option('hours');
        $this->info("🔒 Analyzing security events for the last {$hours} hours...");

        $events = $this->collectSecurityEvents($hours);
        $analysis = $this->analyzeEvents($events);
        
        $this->displayReport($analysis);
        
        // Check for critical threats
        if ($analysis['critical_threats'] > 0) {
            $this->error("⚠️  CRITICAL: {$analysis['critical_threats']} critical security threats detected!");
            Log::channel('security')->critical('Critical security threats detected', $analysis);
        }

        return 0;
    }

    /**
     * Collect security events from cache
     */
    private function collectSecurityEvents(int $hours): array
    {
        $events = [];
        $now = now();
        
        for ($i = 0; $i < $hours; $i++) {
            $hour = $now->subHours($i)->format('Y-m-d-H');
            $key = "security_events:{$hour}";
            $hourEvents = Cache::get($key, []);
            $events = array_merge($events, $hourEvents);
        }

        return $events;
    }

    /**
     * Analyze security events
     */
    private function analyzeEvents(array $events): array
    {
        $analysis = [
            'total_events' => count($events),
            'events_by_type' => [],
            'top_ips' => [],
            'suspicious_patterns' => 0,
            'blocked_agents' => 0,
            'rate_limits' => 0,
            'suspicious_uploads' => 0,
            'critical_threats' => 0,
            'unique_ips' => [],
        ];

        foreach ($events as $event) {
            $type = $event['type'] ?? 'unknown';
            $ip = $event['ip'] ?? 'unknown';

            // Count by type
            $analysis['events_by_type'][$type] = ($analysis['events_by_type'][$type] ?? 0) + 1;

            // Count by IP
            $analysis['top_ips'][$ip] = ($analysis['top_ips'][$ip] ?? 0) + 1;
            $analysis['unique_ips'][$ip] = true;

            // Categorize threats
            switch ($type) {
                case 'suspicious_pattern':
                    $analysis['suspicious_patterns']++;
                    if ($analysis['top_ips'][$ip] > 10) {
                        $analysis['critical_threats']++;
                    }
                    break;
                case 'blocked_user_agent':
                    $analysis['blocked_agents']++;
                    break;
                case 'rate_limit_exceeded':
                    $analysis['rate_limits']++;
                    if ($analysis['top_ips'][$ip] > 50) {
                        $analysis['critical_threats']++;
                    }
                    break;
                case 'suspicious_upload':
                    $analysis['suspicious_uploads']++;
                    $analysis['critical_threats']++;
                    break;
            }
        }

        // Sort top IPs by frequency
        arsort($analysis['top_ips']);
        $analysis['top_ips'] = array_slice($analysis['top_ips'], 0, 10, true);
        $analysis['unique_ips'] = count($analysis['unique_ips']);

        return $analysis;
    }

    /**
     * Display security report
     */
    private function displayReport(array $analysis): void
    {
        $this->info('');
        $this->info('🛡️  SECURITY REPORT');
        $this->info('==================');
        
        $this->table(['Metric', 'Value'], [
            ['Total Events', $analysis['total_events']],
            ['Unique IPs', $analysis['unique_ips']],
            ['Suspicious Patterns', $analysis['suspicious_patterns']],
            ['Blocked User Agents', $analysis['blocked_agents']],
            ['Rate Limit Violations', $analysis['rate_limits']],
            ['Suspicious Uploads', $analysis['suspicious_uploads']],
            ['Critical Threats', $analysis['critical_threats']],
        ]);

        if (!empty($analysis['events_by_type'])) {
            $this->info('');
            $this->info('📊 Events by Type:');
            $eventData = [];
            foreach ($analysis['events_by_type'] as $type => $count) {
                $eventData[] = [$type, $count];
            }
            $this->table(['Type', 'Count'], $eventData);
        }

        if (!empty($analysis['top_ips'])) {
            $this->info('');
            $this->info('🌐 Top Suspicious IPs:');
            $ipData = [];
            foreach ($analysis['top_ips'] as $ip => $count) {
                $status = $count > 50 ? '🔴 CRITICAL' : ($count > 10 ? '🟡 WARNING' : '🟢 NORMAL');
                $ipData[] = [$ip, $count, $status];
            }
            $this->table(['IP Address', 'Events', 'Status'], $ipData);
        }

        // Recommendations
        $this->info('');
        $this->info('💡 Recommendations:');
        
        if ($analysis['critical_threats'] > 0) {
            $this->warn('• Consider blocking IPs with excessive violations');
            $this->warn('• Review and strengthen security rules');
        }
        
        if ($analysis['suspicious_uploads'] > 0) {
            $this->warn('• Review file upload security measures');
        }
        
        if ($analysis['rate_limits'] > 100) {
            $this->warn('• Consider implementing stricter rate limiting');
        }
        
        if ($analysis['total_events'] == 0) {
            $this->info('• No security events detected - system appears secure');
        } else {
            $this->info('• Continue monitoring for patterns');
            $this->info('• Review security logs regularly');
        }
    }
}
