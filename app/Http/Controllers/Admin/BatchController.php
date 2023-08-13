<?php
namespace App\Http\Controllers;

use App\Http\Requests\BatchRequest;
use App\Http\Resources\BatchResource;
use Illuminate\Http\Request;
use App\Models\Batch;

class BatchController extends BaseController
{
    public function index()
    {
        $batches = Batch::all();
        return $this->success(BatchResource::collection($batches),'all batches');
    }

    public function createBatchName(){
        $batch = Batch::select('name')
            ->orderByDesc('name')
            ->value('name');
            $batchId = substr($batch,2);
        if($batchId){
            $batchName = 'Batch-'. $batchId + 1;
        }else{
            $batchName = config('batch.name');
        }
        return $batchName;
    }

   
    public function store(BatchRequest $request)
    {
        $batch = new Batch;
        $batch->name = $this->createBatchName();
        $batch->course_id = $request->course_id;
        $batch->instructor_id = $request->instructor_id;
        $batch->start_date = $request->start_date;
        $batch->end_date = $request->end_date;
        $batch->start_time = $request->start_time;
        $batch->end_time = $request->end_time;
        $batch->status = $request->status;
        $batch->save();
        return $this->success(new BatchResource($batch),'created',config('http_status_code.created'));
    }

    public function show($id)
    {
        $batch = Batch::where('id',$id)->first();
        if(!$batch) {
            return $this->error([],"batch not found",config('http_status_code.not_found'));
        }
        return $this->success($batch,'batch show');
    }

  
    public function update(BatchRequest $request, $id)
    {
        $batch = Batch::where('id',$id)->first();
        if(!$batch) {
            return $this->error([],"batch not found",config('http_status_code.not_found'));
        }
        $batch->name = $batch->name;
        $batch->course_id = $batch->course_id;
        $batch->instructor_id = $request->instructor_id;
        $batch->start_date = $request->start_date;
        $batch->end_date = $request->end_date;
        $batch->start_time = $request->start_time;
        $batch->end_time = $request->end_time;
        $batch->status = $request->status;
        $batch->update();
        return $this->success(new BatchResource($batch),'updated');
    }

    public function destroy($id)
    {
        $batch = Batch::where('id',$id)->first();
        $batch->delete();
        return $this->success([],'deleted',config('http_status_code.no_content'));
    }
}
