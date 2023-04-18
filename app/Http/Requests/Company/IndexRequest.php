<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'=>'numeric',
            'user'=>'numeric',
            'category'=>'numeric',
            'text'=>'string|nullable',
        ];
    }
}
