<?php

namespace App\Http\Requests\comment;

use Illuminate\Foundation\Http\FormRequest;

class comment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!(this['user_id']==auth('sanctum')->user()->id)){
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
            'company_id' => 'required|exists:companies,id',
            'rating' => 'required|min:0|max:5',
            'comment' => 'max:250'
        ];
    }
}
