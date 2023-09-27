<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            '_token' => 'required|string',
            'customerId'  => 'required|string|unique:users,customer_id',
            'email' => 'required|email|max:255|unique:users,email', // Assuming 'users' is the table name
            'username' => 'required|string|max:255|unique:users,username', // Assuming 'users' is the table name
            // 'password' => 'required|string|min:6|confirmed', // Minimum length of 6 and must match password_confirmation
            'password' => 'required|string|confirmed', // Minimum length of 6 and must match password_confirmation
            'password_confirmation' => 'required|same:password'
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'email.required' => 'An email address is required.',
    //         'username.unique' => 'The username has already been taken.',
    //         // ... other custom messages
    //     ];
    // }
}
