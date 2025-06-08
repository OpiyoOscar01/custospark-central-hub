<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return $this->categoryService->getAllCategories();
    }

    public function store(CategoryRequest $request)
    {
        return $this->categoryService->createCategory($request->validated());
    }

    public function show($id)
    {
        return $this->categoryService->getCategoryById($id);
    }

    public function update(CategoryRequest $request, $id)
    {
        return $this->categoryService->updateCategory($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->categoryService->deleteCategory($id);
    }
}
