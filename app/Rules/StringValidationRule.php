<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StringValidationRule implements ValidationRule
{
    protected bool $required;

    protected string $title;

    public function __construct(bool $required = true, $title = '')
    {
        $this->required = $required;
        $this->title = $title;

    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->title) {
            $attribute = $this->title;
        }
dd($attribute);
        if ($this->required && ($value == '')) {
            $fail('The '.$attribute.' field is required.');

            return;
        }

        if (($value != '') && ! preg_match("/^[A-Za-z.&()0-9 ',-]+$/", $value)) {
            $fail('The '.$attribute.' field must contain only alphabetic characters.');
        }
    }
}
