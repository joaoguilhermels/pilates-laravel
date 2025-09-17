<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'class_type_id' => 'required|exists:class_types,id',
            'professional_id' => 'required|exists:professionals,id',
            'room_id' => 'required|exists:rooms,id',
            'class_type_status_id' => 'required|exists:class_type_statuses,id',
            'start_at' => 'required|date',
            'price' => 'nullable|numeric|min:0',
            'observation' => 'nullable|string|max:1000',
        ];
    }
}
