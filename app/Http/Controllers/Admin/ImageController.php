<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ImageRequest;
use Illuminate\Support\Facades\Validator;



class ImageController extends BaseController
{
    public function store(ImageRequest $request) {
        if ($request->course_image) {
            return $this->success($this->handleImageStorage('course_image',$request),'image stored');
        }
        if ($request->user_image) {
            return $this->success($this->handleImageStorage('user_image',$request),'image stored');
        }
    }

    public function handleImageStorage ($imageIdentifier,$folder){
        $file =  storeBase64File($imageIdentifier,$folder);
        $image =  Image::create([
            'image'=> $file
        ]);
        return $image->id;
    }
}
