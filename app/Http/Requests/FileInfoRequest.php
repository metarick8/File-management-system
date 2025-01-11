<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class FileInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = User::firstWhere('id', auth()->user()->id);
        $isMember = false;
        if ($this->has('groupId')) {
            $isMember = $user->members()->where('groupId', $this->groupId)->exists();
        }
        return $isMember;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'ownerId' => 'required|exists:users,id',
            'groupId' => 'required',
            'name' => 'required',
            // 'extension' => 'required',
            'file' => 'required|file',
        ];
    }
    // public function prepareForValidation()
    // {
    //     $this->merge([
    //         'hbd' => 'testing',
    //     ]);
    // }
    // protected function withValidator($validator)
    // {
    //     if ($validator->fails()) {
    //         return;
    //     }

    //     $validator->after(function () {


    //         $file = $this->file('file')->store();

    //         if ($this->has('new')) {
    //             $this->request->remove('new');
    //         }
    //         $this->merge(['dd' => 'ddfd']);
    //     });
    // }
}
