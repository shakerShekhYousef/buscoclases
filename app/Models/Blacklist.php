<?php

namespace App\Models;

use App\Models\Traits\Blacklist\BlacklistRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    use BlacklistRelations;
    use HasFactory;

    protected $guarded = [];
}
