<?php

namespace App\Http\Requests\api\Teacher;

use App\Trait\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateTeacherRequest extends FormRequest
{
    use ResponseTrait;

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
            'name' => 'required|max:50',
            'surname' => 'required|max:50',
            'birth_date' => 'required|date',
            'province' => 'required',
            'city' => 'required',
            'postal_code' => 'required|numeric',
            'gender' => 'required|in:male,female',
            'email' => 'required',
            'phone' => 'required|numeric',
            'nationality' => 'required',
            'schedules' => 'nullable|array',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = $this->error($validator->errors()->first());
        throw new HttpResponseException($response);
    }
}
