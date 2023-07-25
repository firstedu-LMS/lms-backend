<?php

namespace App\Http\Controllers\Admin;

use App\Models\CvForm;
use Illuminate\Http\Request;
use App\Http\Requests\CvFormRequest;
use App\Http\Resources\CvFormResource;
use App\Http\Controllers\BaseController;

class CvFormController extends BaseController
{
    public function index()
    {
        return $this->success(CvFormResource::collection(CvForm::with(['file','user'])->get()),'All courses');
    }
    public function store(CvFormRequest $request)
    {
        $CvForm = new CvForm();
        $CvForm->user_id = $request->user_id;
        $CvForm->file_id = $request->file_id;
        $CvForm->save();
        return $this->success(new CvFormResource($CvForm),'created',config('http_status_code.created'));
    }
    public function show($id)
    {
        $CvForm = CvForm::where('id',$id)->first();
        if(!$CvForm) {
            return $this->error([],"CvForm not found",config('http_status_code.not_found'));
        }
        return $this->success(new CvFormResource($CvForm),'Details of CvForm');
    }
    public function update(CvFormRequest $request, $id)
    {
        $CvForm = CvForm::where('id',$id)->first();
        if(!$CvForm) {
            return $this->error([],"CvForm not found",config('http_status_code.not_found'));
        }
        $CvForm->user_id = $request->user_id;
        $CvForm->file_id = $request->file_id;
        $CvForm->update();
        return $this->success(new CvFormResource($CvForm), config('http_status_code.ok'));
    }

    public function destroy(CvForm $cvForm)
    {
        $cvForm->delete();
        return $this->success([],'deleted',config('http_status_code.no_content'));
    }
}
