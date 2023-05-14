<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Collaborator extends FormRequest
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
            'name' => 'required',
            'username' => 'nullable|unique:users,username,' . $this->id,
            'email' => 'required|email|unique:users,email,' . $this->id,
            'password' => 'nullable|min:8',
            'phone_number' => 'required|numeric|unique:users,phone_number,' . $this->id,
            'date_of_birth' => 'nullable|date',
            'address' => '',
            'civil_status' => 'nullable|in:single,married',
            'gender' => 'in:male,female',
            'id_card_number' => 'required|numeric|unique:users,id_card_number,' . $this->id,
            'nationality' => 'nullable|alpha',
            'university' => 'nullable',
            'history' => '',
            'experience_level' => 'nullable|integer',
            'source' => '',
            'position' => 'required',
            'grade' => '',
            'hiring_date' => 'nullable|date', // contract_start_date
            'contract_end_date' => 'nullable|date',
            'type_of_contract' => 'nullable',
            'allowed_leave_days' => 'integer',
            'department_id' => 'required|integer',
        ];
    }
}
