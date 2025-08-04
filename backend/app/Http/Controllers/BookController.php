<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;
use Exception;

class BookController extends Controller
{
    public function getBooks( Request $request, $id = null)
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
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

public function storeOrUpdate(Request $request, $id = null)
    {
        try {
            $book = BookService::createOrUpdateBook($request->all(), $id);
           return $this->responseJSON([
                'message' => $id ? 'Book updated successfully.' : 'Book created successfully.',
                'data' => $book
            ], 200);
        } catch (\Exception $e) {
             return $this->responseJSON([
                'error' => 'Failed to create or update book.',
                'details' => $e->getMessage()
            ], 500);
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
}
