<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
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
            $data['image'] = $data['image']->store('images/books', 'public');
        }

        $data['is_available'] = ($data['stock'] > 0);

        return Book::create($data);
    }

    public function getBooksByCategory(int $categoryId): Collection
    {
        return Book::where('category_id', $categoryId)
            ->latest('id')
            ->limit(50)
            ->get();
    }

    public function createOrUpdateBook(array $data, ?Book $book = null): Book
    {
        if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->handleImageUpload($data['image'], $book?->image);
        }

        if (isset($data['stock'])) {
            $data['is_available'] = $data['stock'] > 0;
        }

        return $book
            ? tap($book)->update($data)->fresh()
            : Book::create($data);
    }

    public function deleteBook(Book $book): void
    {
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();
    }

    private function handleImageUpload(UploadedFile $imageFile, ?string $oldImagePath = null): string
    {
        if ($oldImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return $imageFile->store('book-covers', 'public');
    }
}
