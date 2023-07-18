<?php

namespace App\Models;

use App\Models\Traits\DeviceTraits\DeviceRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory,DeviceRelationship;

    protected $guarded = [];
}
