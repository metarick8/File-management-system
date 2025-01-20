<?php

namespace App\Http\Requests;

use App\Rules\FileInUserGroup;
use App\Rules\FileIsFree;
use Illuminate\Foundation\Http\FormRequest;

class FileCheckInRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'files' => 'required|array',
            'files.*' => ['required', 'integer', 'distinct'],
            //solve race conditions.. I believed it's solved now
            //put status field in file_infos table
        ];
    }
}
