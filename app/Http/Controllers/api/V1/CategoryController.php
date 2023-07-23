<?php

namespace App\Http\Controllers\api\V1;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCategoryRequest;
use App\Http\Requests\V1\UpdateCategoryRequest;
use Illuminate\Http\Request;
use App\Http\Resources\V1\CategoryCollection;
use App\Http\Resources\V1\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        return new CategoryCollection(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
