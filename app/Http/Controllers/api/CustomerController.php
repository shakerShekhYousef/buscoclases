<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\Customer\CreateCustomerRequest;
use App\Http\Requests\api\Customer\UpdateCustomerImageRequest;
use App\Models\Customer;
use App\Repositories\api\CustomerRepository;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        return $this->customerRepository = $customerRepository;
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
    public function store(CreateCustomerRequest $request)
    {
        $customer = $this->customerRepository->create($request->all());

        return success_response($customer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, Customer $customer)
    {
        $this->customerRepository->update($customer, $request->all());

        return success_response($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function update_image(UpdateCustomerImageRequest $request, Customer $customer)
    {
        $this->customerRepository->updateImage($customer, $request->all());

        return success_response($customer);
    }
}
