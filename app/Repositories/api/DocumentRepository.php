<?php

namespace App\Repositories\api;

use App\Models\Document;
use App\Repositories\BaseRepository;

class DocumentRepository extends BaseRepository
{
    public function model()
    {
        return Document::class;
    }
}
