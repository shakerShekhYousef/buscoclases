<?php

namespace App\Http\Requests\api\Report;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CreateReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
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
            'content' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'teacher_id.required' => 'El campo de identificación de la profesor es obligatorio.',
            'teacher_id.exists' => 'El profesor especificado no es válido.',
            'content.required' => 'El campo Contenido es obligatorio.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json([
            'message' => 'Invalid data send',
            'details' => $errors->messages(),
        ], 422);
        throw new HttpResponseException($response);
    }
}
