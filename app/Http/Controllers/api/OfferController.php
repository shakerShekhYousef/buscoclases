<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\Offer\CheckApplicationOfferRequest;
use App\Http\Requests\api\Offer\CreateOfferRequest;
use App\Http\Requests\api\Offer\UpdateOfferRequest;
use App\Http\Resources\api\ApplicationResource;
use App\Models\Application;
use App\Models\Offer;
use App\Repositories\api\OfferRepository;
use App\Trait\ResponseTrait;
use Carbon\Carbon;

class OfferController extends Controller
{
    use ResponseTrait;

    protected $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::query()->with(['customer','admin'])
            ->whereDate('end_date','>=',date('Y-m-d'))
            ->paginate(20);

        return $this->success($offers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOfferRequest $request)
    {
        $offer = $this->offerRepository->create($request->all());

        return success_response($offer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        return $this->offerRepository->getById($offer->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $this->offerRepository->update($offer, $request->all());

        return success_response($offer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        if (
            auth()->user()->hasAnyRole(['Customer'])
            && $offer->customer->user_id == auth()->user()->id
        ) {
            $this->offerRepository->deleteById($offer->id);

            return success_response('La oferta ha sido eliminada con éxito');
        } else {
            return forbidden_response('No tienes permiso para realizar esta acción.');
        }
    }

    public function check_application(CheckApplicationOfferRequest $request)
    {
        return $this->offerRepository->check_application_for_offer($request->all());
    }

    public function get_offer_applications($id)
    {
        $applications = Application::query()->where('offer_id', $id)->get();

        return success_response(ApplicationResource::collection($applications));
    }
}
