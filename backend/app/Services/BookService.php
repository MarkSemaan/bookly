<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BookService
{
    public static function getBooks(?int $id = null, ?string $search = null)
    {
        if ($id) {
            return Book::find($id);
        }

        return Book::when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%$search%")
                  ->orWhere('author', 'like', "%$search%")
                  ->orWhere('publisher', 'like', "%$search%");
        })->latest('id')->limit(50)->get();
    }

    public static function getBooksByCategory(int $categoryId)
    {
        return Book::where('category_id', $categoryId)->latest('id')->limit(50)->get();
    }
    
       public static function searchBooks(string $term)
    {
        $term = trim($term);

        if ($term === '') {
          
            return collect();
        }

        return Book::where(function ($q) use ($term) {
                $q->where('title',     'LIKE', "%{$term}%")
                  ->orWhere('author',   'LIKE', "%{$term}%")
                  ->orWhere('publisher','LIKE', "%{$term}%");
            })
            ->latest('id')
            ->get();
    }



    public static function createOrUpdateBook(array $data, ?Book $book = null)
    {

        if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = self::handleUploadedImage($data['image'], $book?->image);
        }

        if (!empty($data['image']) && is_string($data['image']) && str_starts_with($data['image'], 'data:image')) {
            $data['image'] = self::handleBase64Image($data['image'], $book?->image);
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

    public static function getTopRatedBooks()
    {
        return Book::where('rating', '>', 0)->orderByDesc('rating')->limit(15)->get();
    }

    public static function getAllBooks()
    {
        return Book::all();
    }

    public static function getAvailable()
    {
        return Book::where('is_available', true)->get();
    }

        private static function handleUploadedImage(UploadedFile $imageFile, ?string $oldImagePath = null): string
    {
        if ($oldImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return $imageFile->store('book-covers', 'public');
    }

    private static function handleBase64Image(string $base64Image, ?string $oldImagePath = null): string
    {
        if ($oldImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        preg_match("/^data:image\/(.*);base64,/", $base64Image, $matches);
        $imageType = $matches[1] ?? 'png';
        $imageData = preg_replace("/^data:image\/(.*);base64,/", '', $base64Image);
        $imageData = base64_decode($imageData);
        $fileName = uniqid() . '.' . $imageType;
        $relativePath = 'book-covers/' . $fileName;
        $storagePath = storage_path('app/public/' . $relativePath);

        if (!file_exists(dirname($storagePath))) {
            mkdir(dirname($storagePath), 0755, true);
        }

        file_put_contents($storagePath, $imageData);

        return 'book-covers/' . $fileName;
    }
}
