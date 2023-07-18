<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherChildMaterial extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function child_material()
    {
        return $this->belongsTo(ChildMaterial::class);
    }
}
