<?php

namespace App\Http\Requests\admin\Offer;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
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
            'customer_id' => 'nullable|exists:customers,id',
            'material_id' => 'required|exists:materials,id',
            'position_title' => 'required|max:50',
            'description' => 'required',
            'job_type' => 'required|in:full_time,part_time',
            'working_hours' => 'required|numeric',
            'start_date' => 'required|date',
            'immediate_incorporation' => 'required|in:0,1',
            'salary' => 'required|numeric',
            'full_salary' => 'required|numeric',
            'level' => 'required',
            'require_experience' => 'required|in:0,1',
            'prepare_official_exam' => 'required|in:0,1',
        ];
    }
}
