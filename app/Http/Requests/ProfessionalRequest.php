<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfessionalRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'compensation_model' => 'required|in:fixed_salary,commission_only,salary_plus_commission',
            'fixed_salary' => 'nullable|numeric|min:0',
            'compensation_notes' => 'nullable|string|max:1000',
        ];
    }
}
