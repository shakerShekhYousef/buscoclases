<?php

namespace App\Models;

use App\Models\Traits\SubjectListTraits\SubjectListRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectList extends Model
{
    use HasFactory,SubjectListRelationship;

    protected $guarded = [];
}
