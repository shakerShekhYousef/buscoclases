<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\Application\ApplicationStatusRequest;
use App\Http\Requests\api\Application\CreateApplicationRequest;
use App\Http\Resources\api\ApplicationResource;
use App\Models\Application;
use App\Repositories\api\ApplicationRepository;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    private $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepository)
    {
        return $this->applicationRepository = $applicationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateApplicationRequest $request)
    {
        $application = $this->applicationRepository->create($request->all());

        return success_response(ApplicationResource::make($application));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        return success_response($application);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $application = Application::find($id);
        if ($application) {
            $this->applicationRepository->deleteById($application->id);

            return success_response('La aplicación ha sido eliminada con éxito');
        } else {
            return error_response('Aplicación no encontrada');
        }
    }

    public function teacher_applications()
    {
        $teacher_id = $_GET['teacher_id'];
        $applications = Application::where('teacher_id', $teacher_id)->paginate(20);

        return success_response(ApplicationResource::collection($applications));
    }

    public function application_status(ApplicationStatusRequest $request)
    {
        $application = $this->applicationRepository->status($request->all());

        return success_response($application);
    }
}
