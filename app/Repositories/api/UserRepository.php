<?php

namespace App\Repositories\api;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return User::class;
    }

    public function updateImage($image)
    {
        $user = auth()->user();
        $user->image = $image;
        $user->save();

        return true;
    }
}
