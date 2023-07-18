<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\Document\GetDocumetsRequest;
use App\Http\Requests\api\Document\UploadDocumentRequest;
use App\Models\Document;
use App\Repositories\api\DocumentRepository;
use App\Trait\FileTrait;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    use FileTrait, ResponseTrait;

    private $repo;

    public function __construct(DocumentRepository $repository)
    {
        $this->repo = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  GetDocumetsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(GetDocumetsRequest $request)
    {
        $request->validate(['teacher_id' => 'required|exists:teachers,id']);
        $files = Document::where('teacher_id', $request['teacher_id'])->first();

        return $this->success($files);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadDocumentRequest $request)
    {
        $data = $request->except('file');
        $data['teacher_id'] = auth()->user()->id;
        if ($request->hasFile('file')) {
            $path = $this->upload($request->file('file'), 'files/teachers');
            $data['cargar_cv'] = $path;
        }
        $check = Document::where('teacher_id', auth()->user()->id)->first();
        $result = $check;
        if ($check) {
            $check->update($data);
            $result = $check;
        } else {
            $data['teacher_id'] = auth()->user()->id;
            $result = $this->repo->create($data);
        }

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
        $repo = $this->repo->with(['teacher']);
        $result = $repo->getById($id);

        return success_response($result);
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
        $result = $this->repo->updateById($id, $request->all());

        return $this->success($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doc = Document::find($id);
        if ($doc->cargar_cv != null) {
            Storage::disk('public')->delete($doc->cargar_cv);
        }
        $doc->cargar_cv = null;
        $doc->save();

        return $this->success();
    }
}
