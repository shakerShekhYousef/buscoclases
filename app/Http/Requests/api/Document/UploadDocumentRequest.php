<?php

namespace App\Http\Requests\api\Document;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UploadDocumentRequest extends FormRequest
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
            'cv' => ['nullable', 'file', 'mimes:jpg,png,jpeg,gif,ppt,pptx,doc,docx,pdf,xls,xlsx,txt', 'max:10000'],
            'violence_victime' => ['nullable', 'in:0,1'],
            'sexual_cert' => ['nullable', 'in:0,1'],
            'job_search_cert' => ['nullable', 'in:0,1'],
            'youth_guarantee' => ['nullable', 'in:0,1'],
            'handicab_cert' => ['nullable', 'in:0,1'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'El campo de título es obligatorio.',
            'file.max' => 'No se pudo cargar un archivo. El tamaño máximo de la imagen es de 2 MB.',
            'file.mimes' => 'El archivo debe ser un archivo de tipo: jpg, png, jpeg, gif, ppt, pptx, doc, docx, pdf, xls, xlsx, txt.',
            'file.required' => 'El campo del archivo es obligatorio.',
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
