<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
        return $this->success($course , 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
