<?php

namespace App\Http\Requests\Panel\V1;

use App\Http\Requests\LifeandmeFormRequest;
use Illuminate\Validation\Rule;

class AdminLoginRequest extends LifeandmeFormRequest
{

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', Rule::exists('admins', 'email')],
            'password' => ['required', 'string',
                //Strong Password
              //  'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                'min:8', 'max:255'],
        ];
    }

}
