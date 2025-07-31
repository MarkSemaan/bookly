<?php

namespace App\Serivces;

use App\Models\Book;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookService
{

    public function getBooks(int $perPage = 15)
    {
        return Book::latest()->paginate($perPage);
    }

    public function getBookById(int $id): ?Book
    {
        return Book::find($id);
    }

    public function createBook(array $data): Book
    {
        if (isset($data['image'])) {
            $data['image_path'] = $data['image']->store('images/books', 'public');
        }

        $data['is_available'] = ($data['stock'] > 0);

        return Book::create($data);
    }


    public static function allBooks(): Collection{
      return Book::all();
    }

    public function updateBook(Book $book, array $data)

    {
        if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->handleImageUpload($data['image'], $book->image);
        }
        if (isset($data['stock'])) {
            $data['is_available'] = $data['stock'] > 0;
        }

        $book->update($data);
        return $book->fresh();
    }

    public function deleteBook(Book $book): void
    {
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }
        $book->delete();
    }

    public function processSale(Book $book, int $quantity = 1): Book
    {
        if ($book->stock < $quantity) {
            throw new \Exception('Not enough stock available to complete the sale.');
        }

        return DB::transaction(function () use ($book, $quantity) {
            $book->stock -= $quantity;
            $book->sold += $quantity;
            $book->is_available = $book->stock > 0;
            $book->save();

            return $book;
        });
    }

    public function restock(Book $book, int $quantity): Book
    {
        $book->stock += $quantity;
        $book->is_available = $book->stock > 0;
        $book->save();

        return $book;
    }

    public function searchBooks(string $query): LengthAwarePaginator
    {
        return Book::where('title', 'LIKE', "%{$query}%")
            ->orWhere('author', 'LIKE', "%{$query}%")
            ->orWhere('publisher', 'LIKE', "%{$query}%")
            ->paginate(15);
    }

    public function getTopRatedBooks(int $limit = 5)
    {
        return Book::where('is_available', true)
            ->orderBy('rating', 'desc')
            ->limit($limit)
            ->get();
    }

    private function handleImageUpload(UploadedFile $imageFile, ?string $oldImagePath = null): string
    {
        if ($oldImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return $imageFile->store('book-covers', 'public');
    }
}
