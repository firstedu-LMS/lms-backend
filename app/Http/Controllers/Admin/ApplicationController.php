<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends BaseController
{
    public function index()
    {
        return $this->success(ApplicationResource::collection(Application::with('cv_form')->get()),'All applications');
    }


    public function store(ApplicationRequest $request)
    {
        $application = new Application();
        $application->gender = $request->gender;
        $application->email = $request->email;
        $application->cv_id = $request->cv_id;
        $application->save();
        return $this->success(new ApplicationResource($application), 'Created',config('http_status_code.created'));
    }

    public function destroy(string $id)
    {
        $application = Application::where('id',$id)->first();
        if(!$application) {
            return $this->error([],"application not found",config('http_status_code.not_found'));
        }
        $application->delete();
        return $this->success([],'deleted',config('http_status_code.no_content'));
    }
}
