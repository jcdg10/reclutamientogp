<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = app('request')->segment(2);

        return [
            'name' => ['required',
                            'string',
                            'max:255'
                            ],
            'email' => ['required',
                    'email',
                    'unique:users,email,'.$id,
                    'max:255'
                    ],
            'password' => [
                        function ($attribute, $value, $fail) {
                                if (strlen($value) > 0) {
                                    if(strlen($value) < 10) {
                                        $fail('El campo password debe tener al menos 10 caracteres.');
                                    }
                                    if(strlen($value) > 40) {
                                        $fail('El campo password no puede tener más de 40 caracteres.');
                                    }
                                }
                        }
                    ],
            'rol' => ['required']
        ];
    }
}
