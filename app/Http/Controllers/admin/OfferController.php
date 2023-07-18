<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\Application\ApplicationStatusRequest;
use App\Http\Requests\admin\Offer\OfferRequest;
use App\Http\Requests\api\Offer\CheckApplicationOfferRequest;
use App\Http\Resources\api\ApplicationResource;
use App\Models\Application;
use App\Repositories\admin\OfferRepository;
use Carbon\Carbon;

class OfferController extends Controller
{
    protected $repo;

    public function __construct(OfferRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = $this->repo->with(['customer', 'admin', 'material','applications']);
        $result = $query->whereDate('end_date','>=',date('Y-m-d'))
            ->all();

        return success_response($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfferRequest $request)
    {
        $data = $request->all();
        if ($request['customer_id'] == null) {
            $data['admin_id'] = auth()->user()->id;
        }
        if($request['end_date'] !== null){
            $data['end_date'] = $request['end_date'];
        }else{
            $date = Carbon::createFromFormat('Y-m-d', $request['start_date']);
            $daysToAdd = 5;
            $data['end_date'] = $date->addDays($daysToAdd);
        }
        $result = $this->repo->create($data);

        return success_response($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->repo->getById($id);

        return success_response($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OfferRequest $request, $id)
    {
        $data = $request->all();
        if($request['end_date']){
            $data['end_date'] = $request['end_date'];
        }else{
            $date = Carbon::createFromFormat('Y-m-d', $request['start_date']);
            $daysToAdd = 5;
            $data['end_date'] = $date->addDays($daysToAdd);
        }
        $result = $this->repo->updateById($id, $data);

        return success_response($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repo->deleteById($id);

        return success_response();
    }

    public function get_offer_applications($id)
    {
        $applications = Application::query()->where('offer_id', $id)->get();

        return success_response(ApplicationResource::collection($applications));
    }
    public function check_application(CheckApplicationOfferRequest $request)
    {
        return $this->repo->check_application_for_offer($request->all());
    }
    public function get_application_by_status(ApplicationStatusRequest $request){
        //Get applications
        $applications = Application::query()->where([
            ['offer_id',$request->offer_id],
            ['status',$request->status]
        ])->with(['teacher','offer'])->get();
        //Response
        return success_response($applications);
    }
}
