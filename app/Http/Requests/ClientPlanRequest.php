<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientPlanRequest extends FormRequest
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
            'start_at' => 'required|date',
            'plan_id' => 'required|exists:plans,id',
            'daysOfWeek' => 'required|array|min:1',
            'daysOfWeek.*.day_of_week' => 'required|integer|between:0,6',
            'daysOfWeek.*.hour' => 'required|integer|between:0,23',
            'daysOfWeek.*.professional_id' => 'required|exists:professionals,id',
            'daysOfWeek.*.room_id' => 'required|exists:rooms,id',
        ];
    }

    public function messages()
    {
        return [
            'start_at.required' => 'Please select a start date for the plan.',
            'plan_id.required' => 'Please select a membership plan.',
            'plan_id.exists' => 'The selected plan is invalid.',
            'daysOfWeek.required' => 'Please add at least one schedule slot.',
            'daysOfWeek.*.day_of_week.required' => 'Please select a day of the week.',
            'daysOfWeek.*.hour.required' => 'Please select a time.',
            'daysOfWeek.*.professional_id.required' => 'Please select a professional.',
            'daysOfWeek.*.room_id.required' => 'Please select a room.',
        ];
    }
}
