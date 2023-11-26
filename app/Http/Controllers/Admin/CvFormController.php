<?php

namespace App\Http\Controllers\Admin;

use App\Models\CvForm;
use Illuminate\Http\Request;
use App\Http\Requests\CvFormRequest;
use App\Http\Resources\CvFormResource;
use App\Http\Controllers\BaseController;



class CvFormController extends BaseController
{
    public function store(CvFormRequest $request)
    {
        $CvForm = new CvForm();
        $file = storeFile($request->file('cv'),'cv');
        $CvForm->cv = $file;
        $CvForm->save();
        return $this->success(new CvFormResource($CvForm),'created',config('http_status_code.created'));
    }
}
