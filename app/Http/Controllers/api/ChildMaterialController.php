<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ChildMaterial;
use Illuminate\Http\Request;

class ChildMaterialController extends Controller
{
    /**
     * get child materials list
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate(['sub_material' => 'required']);
        $list = ChildMaterial::where('sub_material_id', $request['sub_material'])->get();

        return success_response($list);
    }
}
