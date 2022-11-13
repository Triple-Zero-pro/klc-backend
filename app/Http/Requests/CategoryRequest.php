<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => "required|string|min:3|max:191",
            'image' => 'image|max:1048576|dimensions:min_height=50,min_width=50',
            'status' => 'required|in:active,archived',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Category Name Is Required  '
        ];
    }
}
