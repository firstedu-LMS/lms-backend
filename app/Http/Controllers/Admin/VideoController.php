<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\VideoRequest;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function App\Helper\storeFile;

class VideoController extends BaseController
{
    public function store(VideoRequest $request)
    {
        $fileStore = storeFile($request->file('video'), 'video');
        $file =  Video::create([
            'video' => $fileStore
        ]);
        return $this->success($file, 'video stored', config('http_status_code.created'));
    }
}