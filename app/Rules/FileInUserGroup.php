<?php

namespace App\Rules;

use App\Models\FileInfo;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class FileInUserGroup implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = Auth::user();
        if (!$user->members()->whereHas('file_infos', fn($query) => $query->where('id', $value)->where('accepted', 1))->exists())
            $fail("The selected file ID '$value' must be accepted and belong to a group you are a member of.");
    }
}
