<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password; //1

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; //1true
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // create request controler clons hraman
            //1
            'name' => 'required|string|max:255', //partadir|stringic baci vochinch|tareri qanaky
            'email' => 'required|email|unique:users,email|max:255', // //partadir|regexp|chkrknvox
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => [
              'required',
              'string',
              Password::min(3)->mixedCase()->numbers()->symbols()->uncompromised(),
              'confirmed',
            ]
        ];
    }
}
