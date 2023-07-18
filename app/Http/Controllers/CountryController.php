<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Trait\ResponseTrait;

class CountryController extends Controller
{
    use ResponseTrait;

    public function __invoke()
    {
        $list = Country::all();

        return $this->success($list);
    }
}
