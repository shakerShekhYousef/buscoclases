<?php

namespace App\Models;

use App\Models\Traits\ChildMaterial\ChildMaterialRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildMaterial extends Model
{
    use HasFactory, ChildMaterialRelation;

    protected $guarded = [];
}
