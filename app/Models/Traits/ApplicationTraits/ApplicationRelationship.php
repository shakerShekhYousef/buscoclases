<?php

namespace App\Models\Traits\ApplicationTraits;

use App\Models\Offer;
use App\Models\Teacher;

trait ApplicationRelationship
{
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
