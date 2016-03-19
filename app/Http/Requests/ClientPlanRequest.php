<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ClientPlanRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
/*        return [
            'classType' => 'required',
            'plan' => 'required',
            'start_date' => 'required'
        ];*/
        return [];
    }
}
