<?php

namespace App\Http\Controllers;
use App\Services\CategoryService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller{

    public function getAllCategories()
    {
        try {
            $categories = CategoryService::getAllCategories();

            if ($categories->isEmpty()) {
                return $this->fail("No categories found", "fail", 404);
            }

            return $this->responseJSON($categories, "Categories loaded successfully");
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }
    
}
