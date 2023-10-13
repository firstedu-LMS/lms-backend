<?php

namespace App\Services\Client;

use Exception;
use App\Models\Batch;
use App\Models\CoursePerStudent;

class BatchDeletionService
{
    public function deleteBatch($batch)
    {
        $batchHasStudent = CoursePerStudent::where('batch_id', $batch->id)->count();
        if ($batchHasStudent != 0) {
            throw new Exception("Cannot delete this batch. Students are attending it.");
        } else {
            $batch->status = false;
            $batch->update();
            $batch->delete();
        }
    }
}
