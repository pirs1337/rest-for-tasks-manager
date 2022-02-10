<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Requests\Api\V1\ApiRequest;

class RegisterRequest extends ApiRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'username' => ['required', 'string', 'alpha_dash', 'max:255', 'min:2'],
            'email' => ['required', 'unique:users', 'email'],
            'password' => ['required', 'string', 'alpha_dash', 'confirmed']
        ];
    }
}
