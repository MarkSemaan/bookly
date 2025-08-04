<?php


namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public static function getCategories($id = null, $search = null)
    {
        if ($id) {
            return Category::find($id);
        }

        $query = Category::query();

        if ($search) {
            $query->where('name', 'LIKE', "%$search%");
        }

        return $query->latest()->get();
    }

    public static function createOrUpdateCategory(array $data, ?Category $category = null)
    {
        if ($category) {
            $category->update($data);
            return $category;
        }

        return Category::create($data);
    }

    public static function deleteCategory(Category $category): bool
    {
        return $category->delete();
    }
}