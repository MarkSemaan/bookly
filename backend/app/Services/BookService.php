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

    public function allBooks(): Collection
    {
        return Book::all();
    }

    public function findBookByID(int $id): Book
    {
        return Book::findOrFail($id);
    }

    public function updateBook(int $id, array $data)
    {
        $book = Book::findOrFail($id);
        $book->update($data);
        if (isset($data['categories'])) {
            $book->categories()->sync($data['categories']);
        }
        return $book;
    }

    public function deleteBook(int $id): void
    {
        $book = Book::findOrFail($id);
        $book->delete();
    }
}
