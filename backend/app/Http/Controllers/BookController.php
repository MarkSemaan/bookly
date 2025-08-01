<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Models\Book;
use App\Services\BookService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use ResponseTrait;

    protected BookService $service;

    public function __construct(BookService $service)
    {
        $this->service = $service;
    }

    public function getBooks(Request $request)
    {
        try {
            $id = $request->query('id');
            $search = $request->query('search');

            $books = $this->service->getBooks($id, $search);

            return $this->responseJSON($books, $id ? "Book found" : "Books loaded");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function getBooksByCategory(int $categoryId)
    {
        try {
            $books = $this->service->getBooksByCategory($categoryId);
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


            $book = $id ? Book::findOrFail($id) : null;

            $book = $this->service->createOrUpdateBook($validated, $book);

            return $this->responseJSON($book, $id ? "Book updated" : "Book added", $id ? 200 : 201);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function destroy(Book $book)
    {
        try {
            $this->service->deleteBook($book);
            return $this->responseJSON(null, "Book deleted");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }
}
