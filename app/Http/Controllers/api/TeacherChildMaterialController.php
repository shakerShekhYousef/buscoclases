<?php

namespace App\Http\Controllers\api;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Models\ChildMaterial;
use App\Models\TeacherChildMaterial;
use Illuminate\Http\Request;

class TeacherChildMaterialController extends Controller
{
    /**
     * get child material list of a teacher
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'sub_material_id' => 'required',
            'teacher_id' => 'required',
        ]);
        $result = ChildMaterial::join('teacher_child_materials', 'teacher_child_materials.id', '=', 'child_materials.id')
            ->where('teacher_child_materials.teacher_id', $request['teacher_id'])
            ->where('teacher_child_materials.child_material_id', $request['child_material_id'])
            ->get();

        return success_response($result);
    }

    /**
     * add child material
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $request->validate(['child_materials' => 'required|array']);
            $data = [];
            foreach ($request['child_materials'] as $child) {
                $data[] = ['teacher_id' => auth()->user()->id, 'child_material_id' => $child];
            }
            TeacherChildMaterial::where('teacher_id', auth()->user()->id)->delete();
            TeacherChildMaterial::insert($data);

            return success_response();
        } catch (GeneralException $e) {
            throw new GeneralException('error');
        }
    }

    /**
     * remove child material
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TeacherChildMaterial::where('child_material_id', $id)
            ->where('teacher_id', auth()->user()->id)
            ->delete();

        return success_response();
    }
}
