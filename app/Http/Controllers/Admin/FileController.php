<?php

namespace App\Http\Controllers\Admin;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class FileController extends BaseController
{
    public function store(Request $request){
        $filename = time() . "_" . $request->file('file')->getclientoriginalname();
        $fileStore = request()->file('file')->storeas('cvform', $filename);
        $file =  File::create([
            'file'=> $fileStore
        ]);
        return $this->success($file ,'file stored',config('http_status_code.created'));
    }
}
