<?php

namespace App\Models;

use App\Models\Traits\SubMaterial\SubMaterialRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMaterial extends Model
{
    use HasFactory, SubMaterialRelation;

    protected $guarded = [];
}
