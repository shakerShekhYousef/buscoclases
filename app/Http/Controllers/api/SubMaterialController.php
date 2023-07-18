<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\SubMaterial;
use Illuminate\Http\Request;

class SubMaterialController extends Controller
{
    /**
     * get sub materials for material
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate(['material_id' => 'required']);
        $list = SubMaterial::with(['child_materials'])
            ->where('material_id', $request['material_id'])->get();

        return success_response($list);
    }
}
