<?php

namespace App\Http\Requests\Panel\V1;

use App\Http\Requests\LifeandmeFormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends LifeandmeFormRequest
{

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')
                ->ignore($this->route()->parameter('id'))],
            'password' => ['nullable', 'string',
                //Strong Password
              //  'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                'min:8', 'max:255'],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'birth_day' => ['required', 'date'],
            'age' => ['required', 'integer', 'min:1'],
        ];
    }


}
