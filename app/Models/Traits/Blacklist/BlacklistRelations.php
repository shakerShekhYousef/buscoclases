<?php

namespace App\Models\Traits\Blacklist;

use App\Models\Teacher;

trait BlacklistRelations
{
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
