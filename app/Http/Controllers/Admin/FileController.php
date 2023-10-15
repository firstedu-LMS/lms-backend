<?php

namespace App\Http\Controllers\Admin;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class FileController extends BaseController
{
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            $request->file('file') ? 'file' : 'assignment' => 'required|mimes:pdf',
        ]
        );
        if($validator->fails()) {
            return $this->error($validator->errors(),"Validation Error",config('http_status_code.unprocessable_content'));
        }
        if($request->file('assignment')) {
            return $this->handleFileCreate($request,'assignment');
        }else {
            return $this->handleFileCreate($request,'file');
        }
    }
    
    public function handleFileCreate($request,$name)
    {
        $filename = time() . "_" . $request->file($name)->getclientoriginalname();
        $fileStore = $request->file($name)->storeas($name, $filename);
        $file =  File::create([
            'file'=> $fileStore
        ]);
        return $this->success($file ,$name.' stored',config('http_status_code.created'));
    }
}
