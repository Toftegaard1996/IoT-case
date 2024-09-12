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
            'roomName' => 'required|string|max:255',
            'temp' => 'nullable|numeric',
            'humidity' => 'nullable|numeric',
            'noise' => 'nullable|numeric',
            'light' => 'nullable|numeric',
            'brightness' => 'nullable|integer',
            'mode' => 'nullable|string|max:255',
        ];
    }
}
