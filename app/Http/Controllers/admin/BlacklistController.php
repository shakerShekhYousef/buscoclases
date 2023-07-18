<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\Teacher\AddToBlacklist;
use App\Repositories\admin\BlacklistRepository;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class BlacklistController extends Controller
{
    use ResponseTrait;

    protected $blacklistRepo;

    public function __construct(BlacklistRepository $repo)
    {
        $this->blacklistRepo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->blacklistRepo->all();

        return $this->success($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AddToBlacklist  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddToBlacklist $request)
    {
        $data = $this->blacklistRepo->create($request['teacher_id'], $request['note']);

        return $this->success();
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
        if ($this->blacklistRepo->delete($id)) {
            return $this->success();
        }

        return $this->error();
    }
}
