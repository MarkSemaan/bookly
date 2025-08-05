<?php

namespace App\Services;

use App\Actions\GetUserHistories;
use App\Actions\GetUserViews;
use App\Actions\GetUserBooks;
use App\Actions\GetUserReviews;
use App\Services\BookService;
use App\Services\CartService;

class ToolExecutorService
{
    protected array $tool_map;

    public function __construct()
    {
        $this->tool_map = [
            'getUserHistories' => app(GetUserHistories::class),
            'getUserViews' => app(GetUserViews::class),
            'getUserBooks' => app(GetUserBooks::class),
            'getUserReviews' => app(GetUserReviews::class),
        ];
    }

    public function run(string $toolName, int $userId): mixed
    {
        if (isset($this->tool_map[$toolName])) {
            return $this->tool_map[$toolName]->execute($userId);
        }
        return match ($toolName) {
            'getBooks' => BookService::getBooks(),
            'getCategories' => CategoryService::getCategories(),            
            'getCartItems' => CartService::getCartItems($userId),
            'getTopRatedBooks' => BookService::getTopRatedBooks(),
            'getTopSellingBooks' => BookService::getTopSellingBooks(),
            default => throw new \InvalidArgumentException("Unknown tool: $toolName")
        };
    }
}
