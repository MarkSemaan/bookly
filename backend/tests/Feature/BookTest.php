<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;

class BookTest extends TestCase
{
    use RefreshDatabase;

    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/v0.1/guest/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->token = $response->json('payload.token');
    }

    public function test_can_get_all_books()
    {
        Book::factory()->count(5)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/v0.1/user/books/book');

        $response->assertOk()
            ->assertJsonStructure([
                'status',
                'payload' => [
                    '*' => [
                        'id',
                        'title',
                        'author',
                        'created_at',
                        'updated_at',
                        'rating'
                    ]
                ]
            ]);
    }

    public function test_can_get_single_book()
    {
        $book = Book::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/v0.1/user/books/book/' . $book->id);

        $response->assertOk()
            ->assertJsonStructure([
                'status',
                'payload' => [
                    'id',
                    'title',
                    'author',
                    'description',
                    'price',
                    'stock',
                    'publisher',
                    'published_year',
                    'image',
                    'is_available',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function test_can_get_top_rated_books()
    {
        Book::factory()->count(5)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/v0.1/user/books/toprated');

        $response->assertOk()
            ->assertJsonStructure([
                'status',
                'payload' => [
                    '*' => [
                        'id',
                        'title',
                        'author',
                        'created_at',
                        'updated_at',
                        'rating'
                    ]
                ]
            ]);
    }

    public function test_can_create_book()
    {
        $bookData = [
            'title' => 'Test Book',
            'author' => 'Test Author',
            'description' => 'desc',
            'price' => 10.00,
            'stock' => 5,
            'publisher' => 'Test Publisher',
            'published_year' => 2023,
            'sold' => 0,
            'is_available' => true,
            'rating' => 1,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/v0.1/user/books/books', $bookData);

        $response->assertOk()
            ->assertJsonStructure([
                'status',
                'payload' => [
                    'data' => [
                        'id',
                        'title',
                        'author',
                        'description',
                        'price',
                        'stock',
                        'publisher',
                        'published_year',
                        'is_available',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);

        $this->assertDatabaseHas('books', ['title' => 'Test Book']);
    }

    public function test_can_update_book()
    {
        $book = Book::factory()->create();

        $updateData = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'price' => (float)12.50,
            'stock' => 7,
            'publisher' => 'Updated Publisher',
            'published_year' => 2024,
            'sold' => 10,
            'is_available' => true,
            'rating' => 1,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson('/api/v0.1/user/books/books/' . $book->id, $updateData);

        $response->assertOk()
            ->assertJsonStructure([
                'status',
                'payload' => [
                    'data' => [
                        'id',
                        'title',
                        'author',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);

        $this->assertDatabaseHas('books', ['title' => 'Updated Title']);
    }

    public function test_can_delete_book()
    {
        $book = Book::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson('/api/v0.1/user/books/' . $book->id);

        $response->assertOk()
            ->assertJson([
                'status' => 'Book deleted',
                'payload' => true,
            ]);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
