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
 
    public function index()
    {
        $category = Category::all();
        return $this->success(CategoryResource::collection($category),'All categories');
    }

   
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return $this->success(new CategoryResource($category),'Created',config('http_status_code.created'));
    }


    public function show($id)
    {
        $category = Category::where('id',$id)->first();
        if(!$category) {
            return $this->error([],"category not found",config('http_status_code.not_found'));
        }
        return $this->success(new CategoryResource($category),'Details of category');
    }

  
    public function update(CategoryRequest $request,$id)
    {
        $category = Category::where('id',$id)->first();
        if(!$category) {
            return $this->error([],"category not found",config('http_status_code.not_found'));
        }
        $category->name = $request->name;
        $category->update();
        return $this->success(new CategoryResource($category),'Category updated');
    }

    public function destroy($id)
    {
        $category = Category::where('id',$id)->first();
        if(!$category) {
            return $this->error([],'category not found',config('http_status_code.not_found'));
        }
        $category->delete();
        return $this->success([],"success",config('http_status_code.no_content'));
    }
}
