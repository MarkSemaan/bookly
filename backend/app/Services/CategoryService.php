<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories()
    {
        return Category::all();
    }
    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }
    public function updateCategory(array $data, int $id): Category
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }
    public function deleteCategory(int $id): bool
    {
        $category = Category::findOrFail($id);
        return $category->delete();
    }
    public function getCategoryById(int $id): Category
    {
        return Category::findOrFail($id);
    }
}
