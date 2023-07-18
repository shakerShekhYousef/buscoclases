<?php

namespace App\Http\Controllers\api;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Models\SubMaterial;
use App\Models\Teacher;
use App\Models\TeacherSubMaterial;
use Illuminate\Http\Request;

class TeacherSubMaterialController extends Controller
{
    /**
     * get list of sub materials
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'material_id' => 'required|exists:materials,id',
        ]);
        $result = SubMaterial::join('teacher_sub_materials', 'teacher_sub_materials.sub_material_id', '=', 'sub_materials.id')
            ->where('sub_materials.material_id', $request['material_id'])
            ->where('teacher_sub_materials.teacher_id', $request['teacher_id'])
            ->get();

        return success_response($result);
    }

    /**
     * add new sub material to teacher
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $request->validate(['sub_materials' => 'required|array']);
            $data = [];
            foreach ($request['sub_materials'] as $subMat) {
                $data[] = ['teacher_id' => auth()->user()->id, 'sub_material_id' => $subMat];
            }
            TeacherSubMaterial::where('teacher_id')->delete();
            TeacherSubMaterial::insert($data);

            return success_response();
        } catch (GeneralException $e) {
            throw new GeneralException('error');
        }
    }

    /**
     * remove sub material
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TeacherSubMaterial::where('sub_material_id', $id)
            ->where('teacher_id', auth()->user()->id)->delete();

        return success_response();
    }
}
