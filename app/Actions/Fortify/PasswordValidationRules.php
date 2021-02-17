<?php

namespace App\Actions\Fortify;

use JetBrains\PhpStorm\Pure;
use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    #[Pure] protected function passwordRules(): array
    {
        return ['required', 'string', new Password, 'confirmed'];
    }
}
