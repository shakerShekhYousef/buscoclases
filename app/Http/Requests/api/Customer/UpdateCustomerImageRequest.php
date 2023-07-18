<?php

namespace App\Http\Requests\api\Customer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateCustomerImageRequest extends FormRequest
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
            'image' => ['required', 'mimes:jpg,png,jpeg,gif', 'max:2000'],
        ];
    }

    public function messages()
    {
        return[
            'image.required' => 'El campo de la imagen es obligatorio.',
            'image.max' => 'No se pudo cargar una imagen. El tamaño máximo de la imagen es de 2 MB.',
            'image.mimes' => 'El tipo de archivo cargado debe ser una imagen.',
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
