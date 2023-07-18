<?php

namespace App\Models;

use App\Models\Traits\DocumentTraits\DocumentRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use DocumentRelationship,HasFactory;

    protected $guarded = [];
}
