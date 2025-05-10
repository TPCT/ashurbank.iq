<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LingualRegexRule implements ValidationRule
{
    public function __construct(public string $pattern)
    {
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $cleanText = strip_tags($value);
        $cleanText = str_replace('&nbsp;', '', $cleanText);
        preg_match($this->pattern, $cleanText, $matches);
        var_dump($matches);
        if (($result = preg_match($this->pattern, $cleanText)) || ($cleanText && $result == 0)) {
            $fail('The :attribute is invalid.');
        }
    }
}
