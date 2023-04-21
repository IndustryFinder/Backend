<?php

namespace App\Http\Requests\Request;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user=User::find(auth('sanctum')->user()->id);
        if ($user->Company != null)
            return $this['company_id'] == $user->Company->id;
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
            'ad_id' => 'required|exists:ads,id',
            'company_id' => 'required|exists:companies,id',
            'message' => 'required|string',
        ];
    }
}
