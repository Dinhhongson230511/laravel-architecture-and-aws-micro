<?php

namespace App\Http\Requests\Api\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'title' => $this->title ? 'required' : 'nullable',
            'description' => 'nullable',
            'image' => $this->image ? 'required' : 'nullable',
            'price' => $this->price ? 'required' : 'nullable',
        ];
    }
}
