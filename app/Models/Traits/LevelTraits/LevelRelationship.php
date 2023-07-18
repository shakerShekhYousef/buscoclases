<?php

namespace App\Models\Traits\LevelTraits;

use App\Models\Material;
use App\Models\SubMaterial;

trait LevelRelationship
{
    public function sub_material()
    {
        return $this->belongsTo(SubMaterial::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }


}
