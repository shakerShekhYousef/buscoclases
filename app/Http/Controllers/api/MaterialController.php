<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Material;

class MaterialController extends Controller
{
    /**
     * get materials list
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $list = Material::with(['sub_materials', 'levels'])->get();

        return success_response($list);
    }
}
