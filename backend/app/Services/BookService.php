<?php

namespace App\Serivces;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

class BookService
{
    public function createBook(array $data): Book
    {
        return Book::create($data);
    }
    public function updateBook(array $data, int $id): Book
    {
        $book = Book::findOrFail($id);
        $book->update($data);
        return $book;
    }
    public function allBooks(): Collection
    {
        return Book::all();
    }
    public function searchBook() {}
    public function deleteBook(int $id): bool
    {
        $book = Book::findOrFail($id);
        return $book->delete();
    }
}
