<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\GroupOfUser;
use Illuminate\Foundation\Http\FormRequest;

class FileInfoRequest extends FormRequest
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
<<<<<<< HEAD
            //'groupId' => ['required', new GroupOfUser()],
            //'name' => 'required',
=======
            'groupId' => 'required',
            'name' => 'required',
>>>>>>> dccb72ac10b914b59fa2bab734e964cb49847532
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
