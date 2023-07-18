<?php

namespace App\Http\Resources\api;

use App\Models\TeacherMaterial;
use App\Models\TeacherSubMaterial;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"=> $this->id,
            "user_id"=> $this->user_id,
            "name"=> $this->name,
            "surname"=> $this->surname,
            "email"=> $this->email,
            "gender"=> $this->gender,
            "birth_date"=> $this->birth_date,
            "phone"=> $this->phone,
            "image"=> $this->image,
            "province"=> $this->province,
            "city"=> $this->city,
            "nationality"=> $this->nationality,
            "about"=> $this->about,
            "postal_code"=> $this->postal_code,
            "lat"=> $this->lat,
            "lng"=> $this->lng,
            "range"=> $this->range,
            "has_car"=> $this->has_car,
            "has_license"=> $this->has_license,
            "is_active"=> $this->is_active,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
            "materials"=>TeacherMaterial::query()->where('teacher_id',$this->id)
                ->with(['level','material'])->get(),
            "sub_materials"=>TeacherSubMaterial::query()->where('teacher_id',$this->id)
                ->with(['level','sub_material'])->get(),
            "child_materials"=>$this->child_materials
        ];
    }
}
