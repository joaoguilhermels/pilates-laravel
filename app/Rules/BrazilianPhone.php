<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BrazilianPhone implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/\D/', '', $value);
        
        // Check if it's empty after cleaning
        if (empty($phone)) {
            $fail('O campo :attribute deve conter um número de telefone válido.');
            return;
        }
        
        // Brazilian phone patterns
        $patterns = [
            // Mobile with country code: +55 11 99999-9999
            '/^55[1-9]{2}9[0-9]{8}$/',
            // Mobile without country code: 11 99999-9999
            '/^[1-9]{2}9[0-9]{8}$/',
            // Landline with country code: +55 11 3333-3333
            '/^55[1-9]{2}[2-5][0-9]{7}$/',
            // Landline without country code: 11 3333-3333
            '/^[1-9]{2}[2-5][0-9]{7}$/',
            // Mobile with 9th digit: 11 999999999
            '/^[1-9]{2}9[0-9]{8}$/',
            // Old mobile format: 11 99999999
            '/^[1-9]{2}[6-9][0-9]{7}$/',
        ];
        
        $isValid = false;
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $phone)) {
                $isValid = true;
                break;
            }
        }
        
        if (!$isValid) {
            $fail('O campo :attribute deve conter um número de telefone brasileiro válido.');
        }
        
        // Additional validation for known invalid patterns
        if ($this->hasInvalidPattern($phone)) {
            $fail('O campo :attribute contém um número de telefone inválido.');
        }
    }
    
    /**
     * Check for known invalid patterns
     */
    private function hasInvalidPattern(string $phone): bool
    {
        // Check for repeated digits (like 11111111111)
        if (preg_match('/^(\d)\1+$/', $phone)) {
            return true;
        }
        
        // Check for sequential digits (like 12345678901)
        if (preg_match('/^(0123456789|1234567890|9876543210|0987654321)/', $phone)) {
            return true;
        }
        
        // Check for common fake numbers
        $fakeNumbers = [
            '11999999999',
            '11888888888',
            '11777777777',
            '11666666666',
            '11555555555',
            '11444444444',
            '11333333333',
            '11222222222',
            '11111111111',
            '11000000000',
        ];
        
        foreach ($fakeNumbers as $fake) {
            if (str_contains($phone, $fake)) {
                return true;
            }
        }
        
        return false;
    }
}
