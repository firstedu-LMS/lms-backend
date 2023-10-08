<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Batch;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Requests\BatchRequest;
use App\Utils\CheckToDeleteService;
use App\Http\Resources\BatchResource;
use App\Services\BatchDeletionService;
use App\Http\Controllers\BaseController;
use App\Utils\FormatJsonForResponseService\Admin\BatchJson;
use Illuminate\Support\Facades\Validator;

class BatchController extends BaseController
{
    public function index($course_id)
    {
        $batches = Batch::where('course_id', $course_id)->with(['course','instructor.user'])->withTrashed()->first();
        $batches = new BatchJson($batches);
        $data = $batches->getJson();
        return $this->success(BatchResource::collection($data), 'all batches');
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
        $batch = Batch::withTrashed()->where('id',$id)->first();
        if (!$batch) {
            return $this->error([], "batch not found", config('http_status_code.not_found'));
        }
        $data = new BatchJson($batch);
        $batch = $data->getJson();
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

    public function destroy($id,BatchDeletionService $batchDeletionService)
    {
        $batch = Batch::where('id', $id)->first();
        try {
            //logic for deleting the batch are implemented in the service
            $batchDeletionService->deleteBatch($batch);
            return $this->success([], 'deleted', config('http_status_code.no_content'));
        } catch (Exception $e) {
            return $this->error([], $e->getMessage(), config('http_status_code.unprocessable_content'));
        }
    }
}