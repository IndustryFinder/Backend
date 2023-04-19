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
        if(!(this['sender']==auth('sanctum')->user()->id)){
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
            'title' => 'required|min:5|max:50',
            'category_id' => 'required|exists:categories,id',
            'min_budget' => 'min:0',
            'max_budget' => 'number|min:1',
            'description' => 'required|min:10',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
