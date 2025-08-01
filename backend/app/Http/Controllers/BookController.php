<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Models\Book;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Services\BookService;



class BookController extends Controller
{
    use ResponseTrait;

    public function getBooks(Request $request)
    {
        try {
            $id = $request->query('id');
            $search = $request->query('search');

            $service = app()->make(BookService::class);
            if ($id) {
                $books = $service->getBooks($id);
            } else {
                $books = $service->getBooks();
            }

            return $this->responseJSON($books, $id ? "Book found" : "Books loaded");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function getBooksByCategory(int $categoryId)
    {
        try {
            $service = app()->make(BookService::class);
            $books = $service->getBooksByCategory($categoryId);
            return $this->responseJSON($books, "Books by category loaded");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function storeOrUpdate(Request $request)
    {
        try {
            $id = $request->input('id');
            $validated = app(StoreBookRequest::class)->validate($request);

            $service = app()->make(BookService::class);
            $book = $id ? Book::findOrFail($id) : null;

            $book = $service->createOrUpdateBook($validated, $book);

            return $this->responseJSON($book, $id ? "Book updated" : "Book added", $id ? 200 : 201);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function destroy(Book $book)
    {
        try {
            $service = app()->make(BookService::class);
            $service->deleteBook($book);
            return $this->responseJSON(null, "Book deleted");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }
}
