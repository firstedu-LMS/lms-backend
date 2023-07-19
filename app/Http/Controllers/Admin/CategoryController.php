<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\BaseController;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends BaseController
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
    public function create(CategoryRequest $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return $this->success(new CategoryResource($category),201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::where('id',$id)->first();
        if(!$category) {
            return $this->error([],"category not found",404);
        }
        return $this->success(new CategoryResource($category));
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
    public function update(CategoryRequest $request,$id)
    {
        $category = Category::where('id',$id)->first();
        if(!$category) {
            return $this->error([],"category not found",404);
        }
        $category->name = $request->name;
        $category->update();
        return $this->success(new CategoryResource($category),201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::where('id',$id)->first();
        if(!$category) {
            return $this->error([],'category not found',404);
        }
        $category->delete();
        $this->success("success");
    }
}
