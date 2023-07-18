<?php

namespace App\Http\Requests\api\Application;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class ApplicationStatusRequest extends FormRequest
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
            'application_id' => ['required'],
            'status' => ['required', 'in:approved,denied'],
        ];
    }

    public function messages()
    {
        return [
            'application_id.required' => 'El campo de identificación de la aplicación es obligatorio.',
            'status.required' => 'El campo de estado es obligatorio.',
            'status.in' => 'La experiencia requerida seleccionada no es válida.',
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
