<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfficeRoomsRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'roomName' => 'required',
            'temp' => 'string',
            'humidity' => 'string',
            'noise' => 'string',
            'light' => 'string',
            'motion' => 'string',
        ];
    }
}
