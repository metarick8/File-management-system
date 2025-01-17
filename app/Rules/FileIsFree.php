<?php

namespace App\Rules;

use App\Models\FileInfo;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FileIsFree implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $file = FileInfo::find($value);

        if ($file && $file->file_versions()->exists() && $file->file_versions()->latest()->first()->path === null)
            $fail("Cannot check-in on File with ID of '$value' because it's already reserved");
    }
}
