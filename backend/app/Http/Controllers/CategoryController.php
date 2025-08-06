<?php

namespace App\Http\Controllers;


use App\Traits\ResponseTrait;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function getCategories(Request $request, $id = null)
    {
        try {
            $search = $request->query('search');
            $categories = CategoryService::getCategories($id, $search);

            if ($id && !$categories) {
                return $this->fail("Category not found", "fail", 404);
            }

            return $this->responseJSON($categories, $id ? "Category found" : "Categories loaded");

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
