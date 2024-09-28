<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegValidation extends FormRequest
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
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed|alpha_num|min:8',
            'password_confirmation'=>'required',
        ];
    }

    public function messages():array {
        return [
            'password.alpha_num'=>'Password must be alpha-numeric and cannot contain any special character',
            'password.min'=>'Password must have 8 characters long',
        ];
    }


    
}
