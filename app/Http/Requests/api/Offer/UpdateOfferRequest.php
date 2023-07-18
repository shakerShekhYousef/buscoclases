<?php

namespace App\Http\Requests\api\Offer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check() && (bool) auth()->user()->hasRole('Customer');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'position_title' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'lat' => ['nullable', 'numeric'],
            'lng' => ['nullable', 'numeric'],
            'range' => ['nullable', 'numeric'],
            'job_type' => ['required', 'string', 'max:50', 'in:full_time,part_time'],
            'working_hours' => ['nullable', 'numeric'],
            'start_date' => ['nullable', 'date'],
            'salary' => ['nullable', 'numeric'],
            'full_salary' => ['nullable', 'numeric'],
            'subject' => ['nullable', 'string'],
            'level' => ['nullable', 'string'],
            'require_experience' => ['nullable', 'boolean'],
            'prepare_official_exam' => ['nullable', 'boolean'],
            'immediate_incorporation' => ['nullable', 'boolean'],
            'material_id' => ['nullable', 'exists:materials,id'],
        ];
    }

    public function messages()
    {
        return[
            'range.numeric' => 'El rango debe ser un número.',
            'lat.numeric' => 'El lat debe ser un número.',
            'lng.numeric' => 'El lng debe ser un número.',
            'require_experience.in' => 'La experiencia requerida seleccionada no es válida.',
            'prepare_official_exam.in' => 'La experiencia requerida seleccionada no es válida.',
            'immediate_incorporation.in' => 'La experiencia requerida seleccionada no es válida.',
            'job_type.in' => 'La experiencia requerida seleccionada no es válida.',
            'material_id.exists' => 'El material seleccionado no es válido.',
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
