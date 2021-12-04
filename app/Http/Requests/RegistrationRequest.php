<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email'      => 'nullable|string|max:255',
            'password'      => 'string|min:8|max:255',
            'phone'      => 'required|unique:users|string|max:14|min:11',
            //'birthdate'  => 'nullable|date',
            //'image'      => 'nullable|image'
        ];
    }
}
