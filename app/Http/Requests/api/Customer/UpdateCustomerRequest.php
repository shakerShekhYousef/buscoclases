<?php

namespace App\Http\Requests\api\Customer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateCustomerRequest extends FormRequest
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
            'image' => ['nullable', 'mimes:jpg,png,jpeg,gif', 'max:2000'],
            'trade_name' => ['nullable', 'string', 'max:50'],
            'business_name' => ['nullable', 'string', 'max:50'],
            'street' => ['nullable', 'string', 'max:50'],
            'province' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:50'],
            'postal_code' => ['nullable', 'numeric'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'unique:customers,email'],
            'about' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return[
            'image.max' => 'No se pudo cargar una imagen. El tamaño máximo de la imagen es de 2 MB.',
            'image.mimes' => 'El tipo de archivo cargado debe ser una imagen.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo electrónico válida.',
            'email.unique' => 'El email ya ha sido registrado.',
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
