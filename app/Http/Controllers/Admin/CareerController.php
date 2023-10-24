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
        $career =  Career::create($request->validated());
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
    public function edit( $id)
    {
       //     
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CareerRequest $request,  $id)
    {
        $career = Career::where('id',$id)->first();
        if(!$career) {
            return $this->error([],"career not found",config('http_status_code.not_found'));
        }
        $career->update($request->validated());
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
