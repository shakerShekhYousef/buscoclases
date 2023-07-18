<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\Report\CreateReportRequest;
use App\Http\Requests\api\Report\UpdateReportRequest;
use App\Http\Resources\api\TeacherReportResource;
use App\Models\TeacherReport;
use App\Repositories\api\TeacherReportRepository;

class TeacherReportController extends Controller
{
    private $teacherReportRepo;

    public function __construct(TeacherReportRepository $teacherReportRepo)
    {
        return $this->teacherReportRepo = $teacherReportRepo;
    }

    //get teacher in blacklist with reports
    public function index()
    {
        $reports = $this->teacherReportRepo->teachers_on_blacklist();

        return success_response(TeacherReportResource::collection($reports));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateReportRequest $request)
    {
        $report = $this->teacherReportRepo->create($request->all());

        return success_response($report);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportRequest $request, TeacherReport $report)
    {
        $this->teacherReportRepo->update($report, $request->all());

        return success_response($report);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $report = TeacherReport::find($id);
        if ($report) {
            if (
                auth()->user()->hasAnyRole(['Customer'])
                && $report->customer->user_id == auth()->user()->id
            ) {
                $this->teacherReportRepo->deleteById($report->id);

                return success_response('La Informe ha sido eliminada con éxito.');
            } else {
                return forbidden_response('No tienes permiso para realizar esta acción.');
            }
        }

        return error_response('Informe no encontrado');
    }
}
