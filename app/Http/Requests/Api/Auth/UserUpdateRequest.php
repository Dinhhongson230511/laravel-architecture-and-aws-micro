<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'first_name' => empty($this->first_name) ? 'required' : '',
            'last_name' => empty($this->last_name) ? 'required' : '',
            'email' => [empty($this->last_name) ? 'required' : '', 'email:rfc,dns', 'max:60', 'regex:' . config('regex.email')],
        ];
    }

    public function attributes()
    {
        return [
            'email' => __('attribute.email'),
        ];
    }

    public function messages()
    {
        return [
            'email.regex' => __('validation.email'),
        ];
    }
}