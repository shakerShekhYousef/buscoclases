<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\SubMaterial;
use App\Models\Teacher;
use App\Models\TeacherChildMaterial;
use App\Models\TeacherList;
use App\Models\TeacherMaterial;
use App\Models\TeacherSubMaterial;
use App\Repositories\api\TeacherMaterialRepository;
use Illuminate\Http\Request;

class TeacherMaterialController extends Controller
{
    private $repo;

    public function __construct(TeacherMaterialRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * get teacher materials
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
        ]);
        $teacher = TeacherMaterial::query()
            ->where('teacher_id', $request->teacher_id)
            ->with(['material'])
            ->get();

        return success_response($teacher);
    }

    /**
     * add material to teacher
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'materials' => 'required|array',
            'subjects_list' => 'required|array'
        ]);
        $materials = $request->materials;
        foreach ($materials as $material) {
            if (! isset($material['sub_material_id']) && isset($material['material'])) {
                $data[] = [
                    'teacher_id' => auth()->user()->id,
                    'material_id' => $material['material'],
                    'level_id' => $material['level_id']
                ];
                TeacherMaterial::where('teacher_id', auth()->user()->id)->delete();
                TeacherMaterial::insert($data);
            } elseif (isset($material['sub_material_id']) && isset($material['material'])) {
                $data[] = [
                    'teacher_id' => auth()->user()->id,
                    'material_id' => $material['material'],
                    'level_id' => null
                ];
                TeacherMaterial::where('teacher_id', auth()->user()->id)->delete();
                TeacherMaterial::insert($data);
                $sub_materias[] = [
                    'teacher_id' => auth()->user()->id,
                    'sub_material_id' => $material['sub_material_id'],
                    'level_id' => $material['level_id']
                ];
                TeacherSubMaterial::where('teacher_id', auth()->user()->id)->delete();
                TeacherSubMaterial::insert($sub_materias);
            }
            if (isset($material['child_material_id'])) {
                $child_materias[] = [
                    'teacher_id' => auth()->user()->id,
                    'child_material_id' => $material['child_material_id'],
                ];
                TeacherChildMaterial::where('teacher_id', auth()->user()->id)->delete();
                TeacherChildMaterial::insert($child_materias);
            }
        }
        foreach ($request['subjects_list'] as $subject) {
            $subjects_list = TeacherList::create([
                'teacher_id' => auth()->user()->id,
                'subject_list_id' => $subject
            ]);
        }
        $teacher = Teacher::query()->where('user_id', auth()->id())
            ->with(['teacher_lists'])
            ->get();
        return success_response($teacher);
    }

    /**
     * delete material
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TeacherMaterial::where('material_id', $id)
            ->where('teacher_id', auth()->user()->id)->delete();

        return success_response();
    }
}
