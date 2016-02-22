<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ClassTypeStatusRequest extends Request
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
     * @return array
     */
    public function rules()
    {
        return [
            'status_name' => 'array',
            'charge_client' => 'array',
            'pay_professional' => 'array',
            'color' => 'array',
        ];
    }
}
