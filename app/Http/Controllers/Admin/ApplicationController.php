<?php

namespace App\Http\Controllers\Admin;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ApplicationRequest;
use App\Http\Resources\ApplicationResource;

class ApplicationController extends BaseController
{
    public function index()
    {
        return $this->success(Application::all(),'All applications');
    }
    public function store(ApplicationRequest $request)
    {
        $application = new Application();
        $application->gender = $request->gender;
        $application->email = $request->email;
        $cvName = time() . "_" . $request->file('cv')->getClientOriginalName();
        $cv = request()->file('cv')->storeAs('cv', $cvName);
        $application->cv = $cv;
        $application->save();
        return $this->success(new ApplicationResource($application), 'Created',config('http_status_code.created'));
    }
    public function show($id)
    {
        $application = Application::where('id',$id)->first();
        if(!$application) {
            return $this->error([],"application not found",config('http_status_code.not_found'));
        }
        return $this->success(new ApplicationResource($application),'Details of application');
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
