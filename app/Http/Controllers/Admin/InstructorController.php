<?php

namespace App\Http\Controllers\Admin;

use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Resources\InstructorResource;

class InstructorController extends BaseController
{
    public function index()
    {
         $instructors = Instructor::with('cv')->paginate(1);
         $paginationData = [
             'current_page' => $instructors->currentPage(),
             'last_page' => $instructors->lastPage(),
             'per_page' => $instructors->perPage(),
             'total' => $instructors->total(),
         ];
         return $this->success(['instructors' => InstructorResource::collection($instructors) , 'pagination' => $paginationData], 'instructors', 200);
    }

    public function show($id)
    {
        $instructor = Instructor::where('id', $id)->with('cv')->first();
        if (!$instructor) {
            return $this->error([], 'there is no instructor', config('http_status_code.not_found'));
        }
        return $this->success(new InstructorResource($instructor), 'Instructor show for this id');
    }

    public function destroy(Instructor $instructor)
    {
        $instructor->delete();
        return $this->success([], 'deleted', config('http_status_code.no_content'));
    }
}
