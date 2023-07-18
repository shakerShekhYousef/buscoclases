<?php

namespace App\Repositories\api;

use App\Models\TeacherMaterial;
use App\Repositories\BaseRepository;

class TeacherMaterialRepository extends BaseRepository
{
    public function model()
    {
        return TeacherMaterial::class;
    }
}
