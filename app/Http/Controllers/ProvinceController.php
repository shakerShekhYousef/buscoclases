<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Trait\ResponseTrait;

class ProvinceController extends Controller
{
    use ResponseTrait;

    public function __invoke()
    {
        $list = Province::all();

        return $this->success($list);
    }
}
