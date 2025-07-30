<?php

namespace App\Serivces;

use app\Models\Category;

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
}
