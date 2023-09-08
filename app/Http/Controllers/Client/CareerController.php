<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\CareerResource;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CareerController extends BaseController
{
    public function index()
    {

        if (Cache::has('careers')) {
            $careers = Cache::get('careers');
        } else {
            $careers = Cache::rememberForever('careers', function () {
                return  Career::all();
            });
        }

        return $this->success(CareerResource::collection($careers), 'careers');
    }

    public function show($id)
    {
        $career =  Career::where('id', $id)->first();
        return $this->success(new CareerResource($career), 'career show');
    }
}
