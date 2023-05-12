<?php

namespace App\Http\Requests\Ad;

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
            'title' => 'min:5|max:50',
            'isCompany'=>'boolean',
            'category_id' => 'exists:categories,id',
            'min_budget' => 'min:0',
            'max_budget' => 'number|min:1',
            'description' => 'min:10',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
