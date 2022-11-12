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
        $id = 0;

        if ($this->route('category'))
            $id = $this->route('category');

        return [
            'name' => "required|string|min:3|max:191|unique:categories,name,$id",
            'image' => 'image|max:1048576|dimensions:min_height=100,min_width=100',
            'status' => 'required|in:active,archived',
        ];
    }

    public function messages()
    {
        return [
            'name.uniques' => 'This Name Already Exists'
        ];
    }
}
