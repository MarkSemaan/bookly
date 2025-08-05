<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected Book $book;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->book = Book::factory()->create();
    }

    public function test_authenticated_user_can_add_item_to_cart()
    {
        $this->actingAs($this->user, 'api');

        $cartData = [
            'book_id' => $this->book->id,
            'quantity' => 1,
        ];

        $response = $this->postJson('/api/v0.1/user/cartitems/cart', $cartData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'payload' => ['id', 'book_id', 'user_id', 'quantity']
            ])
            ->assertJson([
                'payload' => [
                    'book_id' => $this->book->id,
                    'user_id' => $this->user->id,
                    'quantity' => 1
                ]
            ]);

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $this->user->id,
            'book_id' => $this->book->id,
            'quantity' => 1
        ]);
    }

    public function test_authenticated_user_can_view_their_cart_items()
    {
        $this->actingAs($this->user, 'api');

        CartItem::factory()->create([
            'user_id' => $this->user->id,
            'book_id' => $this->book->id,
        ]);

        $response = $this->getJson('/api/v0.1/user/cartitems');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'payload' => [
                    '*' => ['id', 'book_id', 'user_id', 'quantity']
                ]
            ]);
    }

    public function test_authenticated_user_can_delete_item_from_cart()
    {
        $this->actingAs($this->user, 'api');

        $cartItem = CartItem::factory()->create([
            'user_id' => $this->user->id,
            'book_id' => $this->book->id,
        ]);

        $response = $this->deleteJson("/api/v0.1/user/cartitems/delete/{$cartItem->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'Cart item deleted',
                'payload' => null
            ]);


        $this->assertDatabaseMissing('cart_items', ['id' => $cartItem->id]);
    }

    public function test_unauthenticated_user_cannot_add_item_to_cart()
    {
        $cartData = [
            'book_id' => $this->book->id,
            'quantity' => 1,
        ];

        $response = $this->postJson('/api/v0.1/user/cartitems/cart', $cartData);

        $response->assertStatus(401);
    }

    public function test_add_to_cart_requires_book_id()
    {
        $this->actingAs($this->user, 'api');

        $response = $this->postJson('/api/v0.1/user/cartitems/cart', ['quantity' => 1]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('book_id');
    }

    public function test_add_to_cart_requires_quantity()
    {
        $this->actingAs($this->user, 'api');

        $response = $this->postJson('/api/v0.1/user/cartitems/cart', ['book_id' => $this->book->id]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('quantity');
    }

    public function test_add_to_cart_quantity_must_be_at_least_1()
    {
        $this->actingAs($this->user, 'api');

        $response = $this->postJson('/api/v0.1/user/cartitems/cart', [
            'book_id' => $this->book->id,
            'quantity' => 0
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('quantity');
    }
}
