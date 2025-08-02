<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;


Route::get('/greeting', function () {
    return 'Hello World';
});


Route::prefix('users')->controller(UserController::class)->group(function () {
    Route::get('/', 'getUsers');
    Route::get('/{id}', 'getUsers');
    Route::put('/{id}', 'update');
    Route::put('/{id}/upgrade', 'upgrade');
    Route::get('/{id}/reviews', 'getUserReviews');
});






Route::group(["prefix" => "v0.1"], function () {
    Route::group(["middleware" => "auth:api"], function () {

        //AUTHENTICATED APIs
        Route::group(["prefix" => "user"], function () {
            Route::prefix('books')->group(function () {

                Route::get('/', [BookController::class, 'getBooks']);
                Route::get('/category/{categoryId}', [BookController::class, 'getBooksByCategory']);
                Route::post('/', [BookController::class, 'storeOrUpdate']);
                Route::delete('/{book}', [BookController::class, 'destroy']);
                Route::get('/toprated', [BookController::class, 'getTopRatedBooks']);

            });

            Route::group(["prefix" => "recommender"], function () {
                //APIs for ai
                Route::post('/save_search', [AgentController::class, 'saveSearch']);
                Route::post('/save_view', [AgentController::class, 'saveBookView']);
                Route::get('/get', [AgentController::class, 'getRecommended']);
            });

        });
        //Customer APIs
        Route::prefix('cartitems')->controller(CartController::class)->group(function () {
            Route::get('/', 'getCartItems');
            Route::get('/{id}', 'getCartItems');
            Route::get('/user/{userId}', 'getUserCartItems');
            Route::post('/', 'storeOrUpdate');
            Route::delete('/{cartItem}', 'destroy');
        });



     
            Route::prefix('reviews')->controller(ReviewController::class)->group(function () {
                Route::get('/', 'getReviews');            
                Route::get('/{id}', 'getReviews');
                Route::post('/', 'storeOrUpdate');
                Route::delete('/{id}', 'destroy');
            });


            
        Route::prefix('orders')->controller(OrderController::class)->group(function () {
            Route::get('orders', [OrderController::class, 'getOrders']);
            Route::get('orders/{id}', [OrderController::class, 'getOrders']);
            Route::get('users/{userId}', [OrderController::class, 'getUserOrders']);
            Route::post('/', [OrderController::class, 'storeOrUpdate']);
            Route::post('from-cart/{userId}', [OrderController::class, 'createFromCart']);
            Route::post('{order}/cancel', [OrderController::class, 'cancel']);
            Route::delete('{order}', [OrderController::class, 'destroy']);

        });

        Route::group(["prefix" => "admin"], function () {
            Route::group(["middleware" => "isAdmin"], function () {
                //Admin APIs
            });
        });

    });

    Route::group(["prefix" => "guest"], function () {
        Route::post("/login", [AuthController::class, "login"]);
        Route::post("/register", [AuthController::class, "register"]);

    });
});
