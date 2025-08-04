<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;


class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected $user;



    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'api');
    }

    public function test_authenticated_user_can_create_order()
    {
        $book1 = Book::factory()->create(['price' => 10.00, 'stock' => 5]);
        $book2 = Book::factory()->create(['price' => 20.00, 'stock' => 5]);
        $paymentMethod = PaymentMethod::factory()->create();

        $orderData = [
            'user_id' => $this->user->id,
            'payment_method_id' => $paymentMethod->id,
            'items' => [
                ['book_id' => $book1->id, 'quantity' => 1, 'price' => $book1->price],
                ['book_id' => $book2->id, 'quantity' => 2, 'price' => $book2->price],
            ],
        ];

        $response = $this->postJson('/api/v0.1/orders', $orderData);

        $response->assertCreated()
            ->assertJsonStructure([
                'status',
                'payload' => [
                    'id',
                    'user_id',
                    'total',
                    'status',
                    'items' => [
                        '*' => ['book_id', 'quantity', 'price']
                    ]
                ]
            ]);

        $this->assertEquals(50.00, $response->json('payload.total'));

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'total' => 50.00
        ]);
    }

    public function test_authenticated_user_can_get_their_orders()
    {
        $order1 = Order::factory()->create(['user_id' => $this->user->id]);
        $order2 = Order::factory()->create(['user_id' => $this->user->id]);
        Order::factory()->create(); // other user

        $response = $this->getJson("/api/v0.1/orders/users/{$this->user->id}");

        $response->assertOk()
            ->assertJsonCount(2, 'payload')
            ->assertJsonPath('payload.0.user_id', $this->user->id);
    }

    public function test_authenticated_user_can_get_a_single_order()
    {
        $order = Order::factory()->create(['user_id' => $this->user->id]);
        OrderItem::factory()->count(2)->create(['order_id' => $order->id]);

        $response = $this->getJson("/api/v0.1/orders/orders/{$order->id}");

        $response->assertOk()
            ->assertJsonPath('payload.id', $order->id)
            ->assertJsonStructure([
                'status',
                'payload' => [
                    'id',
                    'items' => [
                        '*' => ['book_id', 'quantity', 'price']
                    ]
                ]
            ]);
    }

    public function test_user_cannot_view_another_users_order()
    {
        $otherUser = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->getJson("/api/v0.1/orders/orders/{$order->id}");

        $response->assertStatus(404); // not found for the wrong user
    }

    public function test_unauthenticated_user_cannot_create_an_order()
    {
        auth()->logout();

        $response = $this->postJson('/api/v0.1/orders', []);
        $response->assertUnauthorized();
    }

    public function test_unauthenticated_user_cannot_view_orders()
    {
        auth()->logout();

        $response = $this->getJson("/api/v0.1/orders/users/{$this->user->id}");
        $response->assertUnauthorized();
    }
}
