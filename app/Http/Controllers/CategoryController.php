<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Category::all());
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());
        return response()->json($category, 201);
    }

    public function show($id): JsonResponse
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(UpdateCategoryRequest $request, $id): JsonResponse
    {
        $category = Category::findOrFail($id);
        $category->update($request->validated());
        return response()->json($category);
    }

    public function destroy($id): JsonResponse
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Category deleted.']);
    }
}
