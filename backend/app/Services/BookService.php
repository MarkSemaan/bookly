<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

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
            $data['image'] = $data['image']->store('images/books', 'public');
        }

        $data['is_available'] = ($data['stock'] > 0);

        return Book::create($data);
    }


    public static function allBooks(): Collection
    {
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
    public function getBestSellers(int $limit = 10)
    {
        return Book::where('is_available', true)
            ->orderBy('sold', 'desc')
            ->limit($limit)
            ->get();
    }
    public function getNewReleases(int $limit = 10)
    {
        return Book::where('is_available', true)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getBooksByCategory(int $categoryId, int $perPage = 15)
    {
        return Book::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        })
            ->where('is_available', true)
            ->paginate($perPage);
    }
    public function updateBookRating(Book $book)
    {
        $averageRating = $book->reviews()->avg('rating') ?? 0;
        $book->rating = round($averageRating);
        $book->save();

        return $book;
    }
}
