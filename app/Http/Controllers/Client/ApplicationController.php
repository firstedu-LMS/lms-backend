<?php

namespace App\Http\Controllers\Client;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ApplicationRequest;
use App\Http\Resources\ApplicationResource;

class ApplicationController extends BaseController
{
   
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

    
}
