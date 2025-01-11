<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
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
            'key' => 'required',
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'new' => 'fostok',
        ]);
    }
    // protected function withValidator($validator)
    // {
    //     if ($validator->fails()) {
    //         return;
    //     }

    //     $validator->after(function () {
    //         // You can check for conditions and modify the request here

    //         // If you want to remove 'dummyKey' after validation
    //         if ($this->has('new')) {
    //             $this->request->remove('new'); // This will remove 'dummyKey' from the request
    //         }
    //         $this->merge(['dd' => 'ddfd']);
    //     });
    // }
}
