<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|min:3|string',
            'email'=>'required|email:rfc|unique:users,email|string',
            'password'=>'required|min:8|confirmed',
        ];
    }
}
