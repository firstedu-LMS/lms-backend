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
        return $this->success(CategoryResource::collection($category),config('err_code.OK'));
    }

   
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return $this->success(new CategoryResource($category),config('err_code.Created'));
    }


    public function show($id)
    {
        $category = Category::where('id',$id)->first();
        if(!$category) {
            return $this->error([],"category not found",config('err_code.Not_Found'));
        }
        return $this->success(new CategoryResource($category));
    }

  
    public function update(CategoryRequest $request,$id)
    {
        $category = Category::where('id',$id)->first();
        if(!$category) {
            return $this->error([],"category not found",config('err_code.Not_Found'));
        }
        $category->name = $request->name;
        $category->update();
        return $this->success(new CategoryResource($category),config('err_code.OK'));
    }

    public function destroy($id)
    {
        $category = Category::where('id',$id)->first();
        if(!$category) {
            return $this->error([],'category not found',config('err_code.Not_Found'));
        }
        $category->delete();
        $this->success("success");
    }
}
