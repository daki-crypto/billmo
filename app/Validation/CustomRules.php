<?php

namespace App\Validation;

class CustomRules
{
    /**
     * Require at least 8 characters with uppercase, lowercase, number, and special character.
     */
    public function strongPassword(?string $value = null): bool
    {
        if ($value === null || $value === '') {
            return false;
        }

        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d\s]).{8,}$/', $value) === 1;
    }
}