<?php

namespace App\Models\Traits\DocumentTraits;

use App\Models\Teacher;

trait DocumentRelationship
{
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
