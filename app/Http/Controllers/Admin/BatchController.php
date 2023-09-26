<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BatchRequest;
use App\Http\Resources\BatchResource;
use App\Http\Controllers\BaseController;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Batch;
use Illuminate\Support\Facades\Validator;

class BatchController extends BaseController
{
    public function index($course_id)
    {
        $course = Course::where('id', $course_id)->first();
        $batches = Batch::where('course_id', $course->id)->with(['course','instructor.user'])->withTrashed()->get();
        return $this->success(BatchResource::collection($batches), 'all batches');
    }

    public function createBatchName($course_id)
    {
        $batch = Batch::where('course_id',$course_id)->withTrashed()->select('name')
            ->orderByDesc('name')
            ->value('name');
            $batchId = substr($batch, 6);
        if ($batchId) {
            $batchName = 'Batch-' . (int)$batchId + 1;
        } else {
            $batchName = config('batch.name');
        }
        return $batchName;
    }


    public function store(BatchRequest $request)
    {
        $data =   $request->validated();
        $data['name'] = $this->createBatchName($request->course_id);
        $batch = Batch::create($data);
        return $this->success(new BatchResource($batch), 'created', config('http_status_code.created'));
    }

    public function show($id)
    {
        $batch = Batch::withTrashed()->where('id', $id)->first();
        if (!$batch) {
            return $this->error([], "batch not found", config('http_status_code.not_found'));
        }
        return $this->success($batch, 'batch show');
    }


    public function update(BatchRequest $request, $id)
    {
        $batch = Batch::withTrashed()->where('id', $id)->first();
        if (!$batch) {
            return $this->error([], "batch not found", config('http_status_code.not_found'));
        }
        $data = $request->validated();
        $batch->update($data);
        if ($batch->status == true || $batch->status == 1) {
            $batch->restore();
        } else {
            $batch->delete();
        }
        return $this->success(new BatchResource($batch), 'updated');
    }

    public function destroy($id)
    {
        $batch = Batch::where('id', $id)->first();
        $batch->status = false;
        $batch->update();
        $batch->delete();
        return $this->success([], 'deleted', config('http_status_code.no_content'));
    }
}
