<?php

namespace App\Http\Requests\Api\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email:rfc,dns', 'max:60', 'regex:' . config('regex.email')],
            'password' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'email' => __('attribute.email'),
            'password' => __('attribute.password'),
        ];
    }

    public function messages()
    {
        return [
            'email.regex' => __('validation.email'),
        ];
    }
}
