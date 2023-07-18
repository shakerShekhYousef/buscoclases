<?php

namespace App\Models;

use App\Models\Traits\GroupMessageTrait\GroupMessageMethod;
use App\Models\Traits\GroupMessageTrait\GroupMessageRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    use HasFactory,GroupMessageRelationship,GroupMessageMethod;

    protected $guarded = [];
}
