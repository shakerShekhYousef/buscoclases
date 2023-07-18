<?php

namespace App\Repositories\admin;

use App\Models\Offer;
use App\Repositories\BaseRepository;

class OfferRepository extends BaseRepository
{
    public function model()
    {
        return Offer::class;
    }
}
