<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Training extends FormRequest
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
            'entitled' => 'required', // custom regex
            'start_date' => 'required|date',
            'duration' => 'required|integer',
            'note' => 'required|numeric'
        ];
    }
}
