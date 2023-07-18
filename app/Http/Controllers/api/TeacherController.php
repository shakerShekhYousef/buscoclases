<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\Document\UploadDocumentRequest;
use App\Http\Requests\api\Teacher\CreateTeacherRequest;
use App\Http\Requests\api\Teacher\GetTeacherApplicationRequest;
use App\Http\Requests\api\Teacher\UpdateTeacherRequest;
use App\Http\Resources\api\ApplicationResource;
use App\Http\Resources\api\TeacherResource;
use App\Models\Document;
use App\Models\SubjectList;
use App\Models\Teacher;
use App\Models\TeacherChildMaterial;
use App\Models\TeacherList;
use App\Models\TeacherMaterial;
use App\Models\TeacherSubMaterial;
use App\Models\User;
use App\Repositories\api\TeacherRepository;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    use ResponseTrait;

    /**
     * create new teacher
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    private $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * register new teacher
     *
     * @param  CreateTeacherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(CreateTeacherRequest $request)
    {
        $user = auth()->user();
        $check = Teacher::where('user_id', $user->id)->first();
        if ($check != null) {
            return $this->forbidden('ya existía');
        }
        $teacher = $this->teacherRepository->create($request->all());

        if ($teacher) {
            return $this->success($teacher);
        }

        return $this->error();
    }

    /**
     * get my profile
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = User::find(auth()->user()->id);
        if ($user->account_type == 'teacher') {
            $teacher = Teacher::where('user_id', $user->id)
                ->with(['teacher_lists','materials','sub_materials','child_materials'])->first();
            $data = $teacher->toArray();
            $data['email'] = $user->email;
            $data['phone'] = $user->phone;

            return response()->json(['status' => 1, 'data' => $data]);
        }
    }

    /**
     * update data
     *
     * @param  UpdateTeacherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeacherRequest $request)
    {
        $user = auth()->user();
        $teacher = Teacher::where('user_id', $user->id)->first();
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

    public function upload_document(UploadDocumentRequest $request)
    {
        $document = $this->teacherRepository->upload_document($request->all());

        return success_response($document);
    }

    public function delete_document($id)
    {
        $document = Document::find($id);
        if (! $document) {
            return not_found_response('Documento no encontrado');
        }
        unlink(public_path('storage/'.$document->file));
        $document->delete();

        return success_response('El documento ha sido eliminado con éxito');
    }

    //Get the teacher's applications with the offer info.
    public function get_teacher_applications(GetTeacherApplicationRequest $request)
    {
        $applications = $this->teacherRepository->get_teacher_applications($request->all());

        return success_response(ApplicationResource::collection($applications));
    }

    //Get subjects list
    public function get_subject_list(){
        $list = SubjectList::all();
        return success_response($list);
    }
    //Get all materias details
    public function all_materias_details(Request $request){
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
        ]);
        $teacher = Teacher::query()->where('id',$request->teacher_id)
            ->first();
        return success_response(TeacherResource::make($teacher));
    }
}
