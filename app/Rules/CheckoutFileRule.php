<?php

namespace App\Rules;

use App\Models\FileInfo;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckoutFileRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        // if (!auth()->user()->file_versions()->where('fileInfoId', $value)->where('path', null)->exists()) {
        //     $fail("Cannot Update File ")
        // }
    }
}
