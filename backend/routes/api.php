<?php

use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NotificationController;

Route::group(["prefix" => "v0.1"], function () {
    Route::group(["middleware" => "auth:api"], function () {

        
        Route::group(["prefix" => "user"], function () {
            Route::prefix('books')->group(function () {
                Route::get('/book/{id?}', [BookController::class, 'getBooks']);
                Route::get('/category/{categoryId}', [BookController::class, 'getBooksByCategory']);

                Route::post('/books', [BookController::class, 'storeOrUpdate']);
                Route::put('/books/{id}', [BookController::class, 'storeOrUpdate']);
                Route::delete('/{book}', [BookController::class, 'destroy']);
                Route::get('/toprated', [BookController::class, 'getTopRatedBooks']);
            });
           
            Route::prefix('categories')->group(function () {
                Route::get('/', [CategoryController::class, 'getCategories']);
            });

            Route::prefix('notifications')->group(function () {
                Route::get('/', [NotificationController::class, 'index']);
                Route::get('/unread', [NotificationController::class, 'unread']);
                Route::post('/read/{id}', [NotificationController::class, 'markAsRead']);
                Route::post('/read-all', [NotificationController::class, 'markAllAsRead']);
            });

            //Customer APIs
            Route::prefix('cartitems')->controller(CartController::class)->group(function () {
                Route::get('/', 'getCartItems');
                Route::get('/{id}', 'getCartItems');
                Route::get('/total/cart', 'getCartTotal');
                Route::get('/user/cart', 'getUserCartItems');
                Route::post('/cart', [CartController::class, 'storeOrUpdate']);
                Route::delete('/delete/{cartItem}', 'destroy');
                Route::post('/decrease', [CartController::class, 'decreaseCartItem']);
            });

            Route::prefix('reviews')->controller(\App\Http\Controllers\ReviewController::class)->group(function () {
                Route::get('/', 'getReviews');
                Route::get('/{id}', 'getReviews');
                Route::post('/', 'storeOrUpdate');
                Route::delete('/{id}', 'destroy');
            });

            Route::prefix('orders')->controller(OrderController::class)->group(function () {
                Route::get('orders', [OrderController::class, 'getOrders']);
                Route::get('orders/{id}', [OrderController::class, 'getOrders']);
                Route::get('users/{userId?}', [OrderController::class, 'getUserOrders']);
                Route::post('/', [OrderController::class, 'storeOrUpdate']);
                Route::post('from-cart', [OrderController::class, 'createFromCart']);
                Route::post('{order}/cancel', [OrderController::class, 'cancel']);
                Route::delete('{order}', [OrderController::class, 'destroy']);
            });

            Route::group(["prefix" => "recommender"], function () {
                //APIs for ai
                Route::post('/save_search', [AgentController::class, 'saveSearch']);
                Route::post('/save_view', [AgentController::class, 'saveBookView']);
                Route::get('/get', [AgentController::class, 'getRecommended']);
            });
        });

        Route::group(["prefix" => "admin"], function () {
            Route::group(["middleware" => "isAdmin"], function () {
                //Admin APIs
                Route::get('/orders', [OrderController::class, 'getAllOrders']);
                Route::post('/orders/move_status/{id}', [OrderController::class, 'moveStatus']);
                Route::get('/books', [BookController::class, 'getAllBooks']);
                Route::get('/dashboard', [AnalyticController::class, 'getAnalytics']);
            });
        });
    });

    Route::group(["prefix" => "guest"], function () {
        Route::post("/login", [AuthController::class, "login"]);
        Route::post("/register", [AuthController::class, "register"]);
    });
});