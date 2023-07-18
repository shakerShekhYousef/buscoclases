<?php

namespace App\Models;

use App\Models\Traits\CustomerTraits\CustomerRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use CustomerRelationship,HasFactory;

    protected $guarded = [];
}
