<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
            'interval' => 'string',
            'celcius' => 'boolean',
            'maxTemp' => 'string',
            'minTemp' => 'string',
            'startHour' => 'string',
            'endHour' => 'string',
        ];
    }
}
