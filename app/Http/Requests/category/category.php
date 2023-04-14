<?php

namespace App\Http\Requests\category;

use Illuminate\Foundation\Http\FormRequest;

class category extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5|max:50',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
