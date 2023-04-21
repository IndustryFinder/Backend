<?php

namespace App\Http\Requests\ad;

use Illuminate\Foundation\Http\FormRequest;

class ad extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!($this['sender']==auth('sanctum')->user()->id)){
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'=>'integer',
            'category'=>'numeric',
            'isCompany'=>'boolean',
            'sender'=>'integer',
            'receiver'=>'integer',
            'text'=>'string|nullable',
        ];
    }
}
