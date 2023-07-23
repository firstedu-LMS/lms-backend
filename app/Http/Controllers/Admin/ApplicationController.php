<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends BaseController
{
    public function index()
    {
        return $this->success(ApplicationResource::collection(Application::all()),'All applications');
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
        Storage::delete($application->cv);
        $application->delete();
        return $this->success([],'deleted',config('http_status_code.no_content'));
    }
}
