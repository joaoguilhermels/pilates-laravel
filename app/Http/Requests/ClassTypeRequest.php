<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ClassTypeRequest extends Request
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
        $rules = [
            'name' => 'required',
            'max_number_of_clients' => 'required|numeric|min:1',
            'duration' => 'required|numeric|min:1',
        ];

        // Commented beacuse we are not allowing users to change status names now
        /*foreach($this->request->get('status') as $key => $val)
        {
            $rules['status.' . $key . '.name'] = 'required';
        }*/

        return $rules;
    }
}
