<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'dateofbirth' => 'required|date_format:Y-m-d|before:today',
            'permenentaddress' => 'required',
            'currentaddress' => 'required',
            'roles' => 'required|array',
            "roles.*"  => "required|exists:roles,id",
            'profileimg' => 'mimes:jpg,png|max:2048'
        ];
    }

     /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages(){
        return [
            'email.unique' => 'The Email Address has already been taken.',
            'roles.*.exists' => 'The selected role is invalid.',
            'dateofbirth.before' => 'The Date of Birth must be a date before today.',
            'profileimg.mimes' => 'The Profile Image must be a file of type: jpg, png.',
            'profileimg.max' => 'The Profile Image must not be greater than 2048 kilobytes.',
            'dateofbirth.required' => 'The Date of Birth field is required.',
            'roles.required' => 'The Role field is required.'
        ];
    }
}
