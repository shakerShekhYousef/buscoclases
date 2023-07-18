<?php

namespace App\Http\Requests\api\Document;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocsRequest extends FormRequest
{
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
            'sexual_cert' => 'nullable',
        ];
    }
}