<?php

namespace App\Models;

use App\Models\Traits\SettingTraits\SettingRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory,SettingRelationship;

    protected $guarded = [];
}
