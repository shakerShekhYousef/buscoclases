<?php

namespace App\Http\Requests\admin\Teacher;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CreateTeacherRequest extends FormRequest
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
            'name' => 'required|max:50',
            'generate_password'=>'required',
            'change_password'=>'required',
            'email_to_send'=>'nullable|email',
            'surname' => 'required|max:50',
            'birth_date' => 'required|date',
            'province' => 'required',
            'city' => 'required',
            'postal_code' => 'required|numeric',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric',
            'nationality' => 'required',
            'schedules' => 'nullable|array',
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
