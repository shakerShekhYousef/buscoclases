<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\Teacher\CreateTeacherRequest;
use App\Http\Requests\admin\Teacher\UpdateVerifyRequest;
use App\Http\Requests\api\Teacher\UpdateTeacherRequest;
use App\Models\Teacher;
use App\Models\TeacherList;
use App\Repositories\admin\TeacherRepository;
use App\Trait\ResponseTrait;

class TeacherController extends Controller
{
    use ResponseTrait;

    protected $teacherRepo;

    /**
     * constructor
     * defining middlewares
     *
     * @return void
     */
    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepo = $teacherRepository;
        $this->middleware('adminRole:view_teacher')->only(['index', 'show']);
    }

    /**
     * get teachers list
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = $this->teacherRepo->all();

        return $this->success($teachers);
    }

    public function store(CreateTeacherRequest $request){
        $teacher = $this->teacherRepo->create($request->all());
        return success_response($teacher);
    }

    /**
     * get teacher details
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teacher = $this->teacherRepo->show($id);
        if ($teacher == null) {
            return $this->not_found('Teacher not found');
        }

        return $this->success($teacher);
    }

    public function update_verify(UpdateVerifyRequest $request,Teacher $teacher){
        $teacher = $this->teacherRepo->update_verify($request->all(),$teacher);
        return success_response($teacher);
    }

    public function update(UpdateTeacherRequest $request,Teacher $teacher)
    {
        $teacher = Teacher::where('user_id', $teacher->id)->first();
        if ($teacher == null) {
            return response()->json(['status' => 0, 'message' => 'please register an account first'], 403);
        }
        $teacher->update($request->except(['schedules','subjects_list']));
        $list = $teacher->teacher_lists;
        $list->each->delete();
        foreach ($request['subjects_list'] as $subject){
            $subjects_list = TeacherList::create([
                'teacher_id'=>$teacher->id,
                'subject_list_id'=>$subject
            ]);
        }
        return response()->json(['status' => 1, 'message' => 'success', 'data' => $teacher]);
    }

    public function destroy(Teacher $teacher){
        $teacher->delete();
        return success_response('Deleted Successfully');
    }


}
