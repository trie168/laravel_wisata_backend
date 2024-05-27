<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::get(env('GOOGLE_RECAPTCHA_SITE_VERIFY'), [
            'secret' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
            'response' => $value
        ]);

        if (!$response->json()["success"]) {
            $fail('The google recaptcha is required.');
        }
    }
}
