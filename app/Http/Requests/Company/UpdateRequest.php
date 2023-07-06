<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'min:5|max:50',
            'category_id' => 'exists:categories,id',
            'email' => 'email:rfc|unique:companies,email',
            'phone' => 'digits_between:10,11',
            'description' => 'max:250',
            'website' => 'url',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
