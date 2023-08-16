<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\CareerRequest;
use App\Http\Resources\CareerResource;
use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends BaseController
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $careers = Career::all();
        return $this->success(CareerResource::collection($careers),'all careers');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CareerRequest $request)
    {
        $career = new Career();
        $career->name  = $request->name ;
        $career->vacancy = $request->vacancy;
        $career->age= $request->age;
        $career->job_description= $request->job_description;
        $career->job_requirement= $request->job_requirement;
        $career->position= $request->position;
        $career->deadline = $request->deadline;
        $career->salary= $request->salary;
        $career->salary_period= $request->salary_period;
        $career->employment_status= $request->employment_status;
        $career->save();
        return $this->success(new CareerResource($career),'created',config('http_status_code.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $career = Career::where('id',$id)->first();
        if (!$career) {
            return $this->error([],'There is no career with this id!!',config('http_status_code.not_found'));
        }
        return $this->success(new CareerResource($career),'Career show for this id');
    }

    /**
     * Show the form for editing the specified resource.
     */
    //public function edit( $id)
   // {
        //
   // }

    /**
     * Update the specified resource in storage.
     */
    public function update(CareerRequest $request,  $id)
    {
        $career = Career::where('id',$id)->first();
        if(!$career) {
            return $this->error([],"career not found",config('http_status_code.not_found'));
        }
        $career->name  = $request->name ;
        $career->vacancy = $request->vacancy;
        $career->age= $request->age;
        $career->job_description= $request->job_description;
        $career->job_requirement= $request->job_requirement;
        $career->position= $request->position;
        $career->salary= $request->salary;
        $career->deadline = $request->deadline;
        $career->salary_period= $request->salary_period;
        $career->employment_status= $request->employment_status;
        $career->update();
        return $this->success(new CareerResource($career),'updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Career $career)
    {
        $career->delete();
        return $this->success([],'deleted',config('http_status_code.no_content'));
    }
}
