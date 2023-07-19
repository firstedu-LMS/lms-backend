<?php

namespace App\Http\Controllers\Admin;

use App\Events\CourseCreated;
use App\Http\Controllers\BaseController;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;

class CourseController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Event::dispatch(new CourseCreated());

        $course = cache('courses',function (){
            return  Course::latest()->take(4)->get();
        });

        return $this->success(CourseResource::collection($course));

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $filename = time() . "_" . $request->file('image')->getClientOriginalName();
        request()->file('image')->storeAs('course_image', $filename);
        $course = new Course();
        $course->name =  $request->name;
        $course->category_id =  $request->category_id;
        $course->description =  $request->description ;
        $course->fee =  $request->fee;
        $course->status =   $request->status ;
        $course->available = json_decode($request->available);
        $course->save(); 
        $course->image()->create(['image' => $filename]);
        return $this->success($course , config('err_code.OK'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $course = Course::where('id',$id)->first();
        if(!$course) {
            return $this->error([],"course not found",config('err_code.Not_Found'));
        }
        return $this->success(new CourseResource($course));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, string $id)
    {
        // $course = Course::where('id',$id)->first();
        
        // if(!$course) {
        //     return $this->error([],"course not found",config('err_code.Not_Found'));
        // }

        // if($request->file('image')){
        //     $course->image->delete();
        //     Storage::delete($course->image->image);
        //     $filename = time() . "_" . $request->file('image')->getClientOriginalName();
        //     request()->file('image')->storeAs('course_image', $filename);
        //     $course->image()->create(['image' => $filename]);
        // }

        // $course->name = $request->name;
        // $course->description = $request->description;
        // $course->fee = $request->fee;
        // $course->status = $request->status;
        // $course->available = json_decode($request->available);
        // $course->update();
        // return $this->success(new CourseResource($course));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::where('id',$id)->first();
        if(!$course) {
            return $this->error([],"course not found",config('err_code.Not_Found'));
        }
        $course->image->delete();
        Storage::delete('course_image/'.$course->image->image);
        $course->delete();
        $this->success([$course,"message" => "successfully deleted"]);
    }
}
