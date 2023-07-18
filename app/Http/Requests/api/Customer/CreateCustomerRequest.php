<?php

namespace App\Http\Requests\api\Customer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CreateCustomerRequest extends FormRequest
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
            'trade_name' => ['required', 'string', 'max:50'],
            'business_name' => ['required', 'string', 'max:50'],
            'street' => ['required', 'string', 'max:50'],
            'province' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:50'],
            'postal_code' => ['required', 'numeric'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'about' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'El campo de la imagen es obligatorio.',
            'trade_name.required' => 'El campo nombre comercial es obligatorio.',
            'business_name.required' => 'El campo de la imagen es obligatorio.',
            'street.required' => 'El campo de la calle es obligatorio.',
            'province.required' => 'El campo provincia es obligatorio.',
            'city.required' => 'El campo de la ciudad es obligatorio.',
            'postal_code.required' => 'El campo del código postal es obligatorio.',
            'email.required' => 'El campo de correo electrónico es obligatorio.',
            'about.required' => 'El campo Acerca de es obligatorio.',
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
