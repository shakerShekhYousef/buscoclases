<?php

namespace App\Http\Requests\api\Offer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CreateOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'position_title' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'range' => ['required', 'numeric'],
            'job_type' => ['required', 'string', 'max:50', 'in:full_time,part_time'],
            'working_hours' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'salary' => ['required', 'numeric'],
            'full_salary' => ['required', 'numeric'],
            'level' => ['required', 'string'],
            'require_experience' => ['required', 'in:0,1'],
            'prepare_official_exam' => ['required', 'in:0,1'],
            'immediate_incorporation' => ['required', 'in:0,1'],
            'material_id' => ['required', 'exists:materials,id'],
        ];
    }

    public function messages()
    {
        return [
            'position_title.required' => 'El campo del título del puesto es obligatorio.',
            'description.required' => 'El campo de descripción es obligatorio.',
            'lat.required' => 'El campo lat es obligatorio.',
            'lng.required' => 'El campo lng es obligatorio.',
            'range.required' => 'El campo de rango es obligatorio.',
            'job_type.required' => 'El campo tipo de trabajo es obligatorio.',
            'start_date.required' => 'El campo de fecha de inicio es obligatorio.',
            'salary.required' => 'El campo salario es obligatorio.',
            'full_salary.required' => 'El campo de salario completo es obligatorio.',
            'subject.required' => 'El campo de asunto es obligatorio.',
            'level.required' => 'El campo de nivel es obligatorio.',
            'require_experience.required' => 'El campo de experiencia requerida es obligatorio.',
            'prepare_official_exam.required' => 'El campo preparar examen oficial es obligatorio.',
            'immediate_incorporation.required' => 'El campo de incorporación inmediata es obligatorio.',
            'range.numeric' => 'El rango debe ser un número.',
            'lat.numeric' => 'El lat debe ser un número.',
            'lng.numeric' => 'El lng debe ser un número.',
            'require_experience.in' => 'La experiencia requerida seleccionada no es válida.',
            'prepare_official_exam.in' => 'La experiencia requerida seleccionada no es válida.',
            'immediate_incorporation.in' => 'La experiencia requerida seleccionada no es válida.',
            'job_type.in' => 'La experiencia requerida seleccionada no es válida.',
            'material_id.required' => 'El campo de identificación de la material es obligatorio.',
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
