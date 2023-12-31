<?php

namespace App\Http\Requests\admin\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class AddToBlacklist extends FormRequest
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
            'teacher_id' => ['required', 'exists:teachers,id'],
        ];
    }
}
