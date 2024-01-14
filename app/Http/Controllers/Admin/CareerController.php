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

    }

    public function saveCareer($request, $id = null)
    {
        $data = $request->validated();
        if($id) {
            $career = Career::where('id',$id)->first();
            if(!$career) {
                return $this->error([],"career not found",config('http_status_code.not_found'));
            }
            $career->update($data);
            return $this->success(new CareerResource($career),'updated');
        }else {
            $career =  Career::create($data);
            return $this->success(new CareerResource($career),'created',config('http_status_code.created'));
        }
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
     * Update the specified resource in storage.
     */
    public function update(CareerRequest $request,  $id)
    {
        return $this->saveCareer($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Career $career)
    {
        $career->delete();
        return $this->success([],'deleted',config('http_status_code.no_content'));
    }


    public function multiDelete(Request $request){
        logger($request->all());
        //Career::destroy($request->idArray);
        return $this->success([],'deleted',config('http_status_code.no_content'));
    }
}
