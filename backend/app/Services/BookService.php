<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


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

        return Book::where('category_id', $categoryId)
           ->latest('id')
           ->limit(50)
           ->get();

    }

 public static function createOrUpdateBook(array $data, $id = null)
    {
       $rules = [
    'title' => 'required|string|max:255',
    'author' => 'required|string|max:255',
    'publisher' => 'nullable|string|max:255',
    'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
    'description' => 'nullable|string',
    'price' => 'required|numeric|min:0',
    'stock' => 'required|integer|min:0',
    'image' => 'nullable|string',
    'sold' => 'nullable|integer|min:0',
    'is_available' => 'boolean',
    'rating' => 'nullable|integer|min:0|max:5',
    'category_id' => 'nullable|integer|exists:categories,id' 
];


        if ($id) {
            $rules['id'] = 'integer|exists:books,id';
        }

        $validator = Validator::make($data, $rules);
        $validated = $validator->validated();

        if (!empty($validated['image']) && str_starts_with($validated['image'], 'data:image')) {
            $validated['image'] = self::saveBase64Image($validated['image']);
        }

        $book = $id ? Book::find($id) : new Book();
        $book->fill($validated);
        $book->save();

        return $book;
    }


    private static function saveBase64Image($base64Image)
    {
        preg_match("/^data:image\/(.*);base64,/", $base64Image, $matches);
        $imageType = $matches[1] ?? 'png';

        $imageData = preg_replace("/^data:image\/(.*);base64,/", '', $base64Image);
        $imageData = base64_decode($imageData);

        $fileName = uniqid() . '.' . $imageType;
        $relativePath = 'images/' . $fileName;
        $storagePath = storage_path('app/public/' . $relativePath);

        if (!file_exists(dirname($storagePath))) {
            mkdir(dirname($storagePath), 0755, true);
        }

        file_put_contents($storagePath, $imageData);

        return 'storage/' . $relativePath;
    }
    
    public static function deleteBook(Book $book)

    {
        $book = Book::find($book_id);
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        return $book->delete();
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

    public static function getTopRatedBooks()
    {
        return Book::where('rating', '>', 0)->orderByDesc('rating')->limit(15)->get();
    }
  
    public static function getAllBooks()
    {
        $books = Book::all();
        return $books;
    }

    public static function available()
    {
        $books = Book::where('is_available', true);
        return $books;
    }
}
