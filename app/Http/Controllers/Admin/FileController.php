<?php

namespace App\Http\Controllers\Admin;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\FileRequest;
use Illuminate\Support\Facades\Validator;



class FileController extends BaseController
{
    public function store(FileRequest $request)
    {
        if ($request->file('assignment')) {
            return $this->handleFileCreate($request, 'assignment');
        } else if ($request->file('submission_file')) {
            return $this->handleFileCreate($request, 'submission_file');
        } else {
            return $this->handleFileCreate($request, 'file');
        }
    }

    public function handleFileCreate($request, $name)
    {
        $fileStore = storeFile($request->file($name), $name);
        $file =  File::create([
            'file' => $fileStore
        ]);
        return $this->success($file, $name . ' stored', config('http_status_code.created'));
    }
}