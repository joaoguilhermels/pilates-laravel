<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotBlacklistedEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value) {
            return;
        }

        $email = strtolower(trim($value));
        $domain = substr(strrchr($email, '@'), 1);
        
        $blacklistedDomains = config('security.email_blacklist', []);
        
        // Check if the domain is blacklisted
        if (in_array($domain, $blacklistedDomains)) {
            $fail('Este domínio de email não é permitido. Use um email válido.');
            return;
        }
        
        // Check for suspicious patterns
        if ($this->hasSuspiciousPatterns($email)) {
            $fail('Este email contém padrões suspeitos. Use um email válido.');
            return;
        }
        
        // Check for common spam patterns
        if ($this->isSpamPattern($email)) {
            $fail('Este email parece ser temporário ou spam. Use um email permanente.');
            return;
        }
    }
    
    /**
     * Check for suspicious patterns in email
     */
    private function hasSuspiciousPatterns(string $email): bool
    {
        $suspiciousPatterns = [
            '/\+.*\+/', // Multiple plus signs
            '/\.{2,}/', // Multiple consecutive dots
            '/[0-9]{10,}/', // Long sequences of numbers
            '/temp|trash|spam|fake|test|dummy/i', // Suspicious keywords
            '/^[a-z]{1,2}[0-9]+@/', // Very short prefix with numbers
            '/^[0-9]+@/', // Starting with numbers only
        ];
        
        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $email)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Check for common spam email patterns
     */
    private function isSpamPattern(string $email): bool
    {
        $localPart = substr($email, 0, strpos($email, '@'));
        
        // Check for very short local parts (less than 3 characters)
        if (strlen($localPart) < 3) {
            return true;
        }
        
        // Check for all numbers in local part
        if (is_numeric($localPart)) {
            return true;
        }
        
        // Check for repeated characters
        if (preg_match('/(.)\1{4,}/', $localPart)) {
            return true;
        }
        
        // Check for common spam prefixes
        $spamPrefixes = [
            'noreply',
            'no-reply',
            'donotreply',
            'admin',
            'administrator',
            'root',
            'postmaster',
            'webmaster',
            'support',
            'info',
            'sales',
            'marketing',
        ];
        
        foreach ($spamPrefixes as $prefix) {
            if (str_starts_with($localPart, $prefix)) {
                return true;
            }
        }
        
        return false;
    }
}
