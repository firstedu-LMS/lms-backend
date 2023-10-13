<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideoController extends BaseController
{
    public function store(Request $request){
        //validation rules needed to fix
        $validator = Validator::make($request->all(),[
            'video'  => 'mimes:mp4,mov,ogg | max:20000',
        ]
        );
        if($validator->fails()) {
            return $this->error($validator->errors(),"Validation Error",config('http_status_code.unprocessable_content'));
        }
        $filename = time() . "_" . $request->file('video')->getclientoriginalname();
        $fileStore = request()->file('video')->storeas('videos', $filename);
        $file =  Video::create([
            'video'=> $fileStore
        ]);
        return $this->success($file ,'video stored',config('http_status_code.created'));
    }
}
