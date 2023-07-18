<?php

namespace App\Http\Requests\api\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'nullable|max:50',
            'surname' => 'nullable|max:50',
            'birth_date' => 'nullable|date',
            'province' => 'nullable',
            'city' => 'nullable',
            'postal_code' => 'nullable|numeric',
            'gender' => 'nullable',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'range' => 'nullable|numeric',
        ];
    }
}
