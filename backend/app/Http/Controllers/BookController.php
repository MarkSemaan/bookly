<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;
use Exception;

class BookController extends Controller
{
    public function getBooks($id = null, Request $request)
    {
        try {
            $search = $request->query('search');
            $books = BookService::getBooks($id, $search);

            if ($id && !$books) {
                return $this->fail("Book not found", "fail", 404);
            }

            return $this->responseJSON($books, $id ? "Book found" : "Books loaded");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }
    public function getTopRatedBooks()
    {
        $books = BookService::getTopRatedBooks();
        return $this->responseJSON($books);
    }
    public function getTopSellingBooks()
    {
        try {
            $books = BookService::getTopSellingBooks();
            return $this->responseJSON($books, "Top 15 best-selling books loaded");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }
    public function getBooksByCategory(int $categoryId)
    {
        try {
            $books = BookService::getBooksByCategory($categoryId);
            return $this->responseJSON($books, "Books by category loaded");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function storeOrUpdate(StoreBookRequest $request)
    {
        try {
            $validated = $request->validated();
            $id = $validated['id'] ?? null;
            $book = $id ? Book::find($id) : null;

            if ($id && !$book) {
                return $this->fail("Book not found", "fail", 404);
            }

            $result = BookService::createOrUpdateBook($validated, $book);


            return $this->responseJSON($result, $id ? "Book updated" : "Book added", $id ? 200 : 201);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function destroy(Book $book)
    {
        try {
            BookService::deleteBook($book);
            return $this->responseJSON(null, "Book deleted");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function getAllBooks()
    {
        try {
            $books = BookService::getAllBooks();
            return $this->responseJSON($books);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }
}
