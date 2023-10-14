<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class ImageController extends BaseController
{
    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            $request->file('course_image') ? 'course_image' : 'user_image' => 'required|mimes:png,jpeg,jpg',
        ]
        );
        if($validator->fails()) {
            return $this->error($validator->errors(),"Validation Error",config('http_status_code.unprocessable_content'));
        }
        if ($request->file('course_image')) {
            return $this->success($this->handleImageStorage('course_image',$request),'image stored');
        }
        if ($request->file('user_image')) {
            return $this->success($this->handleImageStorage('user_image',$request),'image stored');
        }
    }

    protected function handleImageStorage (string $imageIdentifier,$request){
        $filename = time() . "_" . $request->file($imageIdentifier)->getClientOriginalName();
        $file = request()->file($imageIdentifier)->storeAs($imageIdentifier, $filename);
        $image =  Image::create([
            'image'=> $file
        ]);
        return $image;
    }
}
