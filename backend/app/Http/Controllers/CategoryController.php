<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Models\Category;


class CategoryController extends Controller
{

    public function getAllCategories()
    {
        try {
            $categories = CategoryService::getAllCategories();

            if ($categories->isEmpty()) {
                return $this->fail("No categories found", "fail", 404);
            }

            return $this->responseJSON($categories, "Categories loaded successfully");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }


    public function storeOrUpdate(StoreCategoryRequest $request)
    {
        try {
            $validated = $request->validated();
            $id = $validated['id'] ?? null;
            $category = $id ? Category::find($id) : null;

            if ($id && !$category) {
                return $this->fail("Category not found", "fail", 404);
            }

            $result = CategoryService::createOrUpdateCategory($validated, $category);

            return $this->responseJSON($result, $id ? "Category updated" : "Category created", $id ? 200 : 201);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return $this->fail("Category not found", "fail", 404);
            }

            CategoryService::deleteCategory($category);

            return $this->responseJSON(null, "Category deleted");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }
}
