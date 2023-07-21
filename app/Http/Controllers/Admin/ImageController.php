<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends BaseController
{
    public function store(Request $request) {
        if ($request->file('course_image')) {
            return $this->success($this->handleImageStorage('course_image',$request),'image stored');
        }
        if ($request->file('user_image')) {
            return $this->success($this->handleImageStorage('user_image',$request),'image stored');
        }
    }

    protected function handleImageStorage (string $imageIdentifier,$request){
        $filename = time() . "_" . $request->file($imageIdentifier)->getClientOriginalName();
        request()->file($imageIdentifier)->storeAs($imageIdentifier, $filename);
        $image =  Image::create([
            'image'=> $filename
        ]);
        return $image;
    }
}
