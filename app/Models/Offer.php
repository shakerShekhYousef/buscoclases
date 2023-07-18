<?php

namespace App\Models;

use App\Models\Traits\OfferTraits\OfferRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use OfferRelationship,HasFactory;

    protected $guarded = [];
}
