<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookService
{
    public static function getBooks(?int $id = null, ?string $search = null)
    {
        if ($id) {
            return Book::find($id);
        }

        return Book::when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%$search%")->orWhere('author', 'like', "%$search%")->orWhere('publisher', 'like', "%$search%");
        })->latest('id')->limit(50)->get();
    }

    public static function getBooksByCategory(int $categoryId)
    {
        return Book::where('category_id', $categoryId) ->latest('id') ->limit(50) ->get();
    }

    public static function createOrUpdateBook(array $data, ?Book $book = null)
    {
        if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = self::handleImageUpload($data['image'], $book?->image);
        }

        if (isset($data['stock'])) {
            $data['is_available'] = $data['stock'] > 0;
        }

        if ($book) {
            $book->update($data);
            return $book->fresh();
        }

        return Book::create($data);
    }

    public static function deleteBook(Book $book)
    {
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();
    }
    public static function getTopSellingBooks()
    {
        
        return Book::where('sold', '>', 0)->orderByDesc('sold')->limit(15)->get();
    }

    private static function handleImageUpload(UploadedFile $imageFile, ?string $oldImagePath = null): string
    {
        if ($oldImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return $imageFile->store('book-covers', 'public');
    }
  
    public static function available()
    {
        $books = Book::where('is_available', true)->get();
        return $books;
    }
  
    public static function getBooksByIds($book_ids)
    {
        $recommended = Book::whereIn('id', $book_ids)->get();
        return $recommended;
    }

    public static function getTopRatedBooks(): \Illuminate\Support\Collection
        {
            return Book::where('rating', '>', 0)->orderByDesc('rating')->limit(15)->get();
        }

}
