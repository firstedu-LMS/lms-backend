<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ImageRequest;
use Illuminate\Support\Facades\Validator;

use function App\Helper\storeFile;

class ImageController extends BaseController
{
    public function store(ImageRequest $request) {
        if ($request->file('course_image')) {
            return $this->success($this->handleImageStorage('course_image',$request),'image stored');
        }
        if ($request->file('user_image')) {
            return $this->success($this->handleImageStorage('user_image',$request),'image stored');
        }
    }

    protected function handleImageStorage (string $imageIdentifier,$request){
        $file = storeFile($request->file($imageIdentifier),$imageIdentifier);
        $image =  Image::create([
            'image'=> $file
        ]);
        return $image;
    }
}
