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
use App\Http\Controllers\CategoryController;


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

Route::prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'getCategories');
    Route::get('/{id}', 'getCategories');
    Route::post('/', 'storeOrUpdate');
    Route::post('/{id}', 'storeOrUpdate');
    Route::delete('/{id}', 'destroy');
});



Route::group(["prefix" => "v0.1"], function () {
    Route::group(["middleware" => "auth:api"], function () {

        
        Route::group(["prefix" => "user"], function () {
            Route::prefix('books')->group(function () {

                Route::get('/book/{id?}', [BookController::class, 'getBooks']);
                Route::get('/category/{categoryId}', [BookController::class, 'getBooksByCategory']);
                Route::post('/', [BookController::class, 'storeOrUpdate']);
                Route::delete('/{book}', [BookController::class, 'destroy']);
                Route::get('/toprated', [BookController::class, 'getTopRatedBooks']);
            });

            Route::prefix('categories')->group(function () {
               Route::get('/', [CategoryController::class, 'getCategories']);
            });
           

            Route::group(["prefix" => "recommender"], function () {
  
                Route::post('/save_search', [AgentController::class, 'saveSearch']);
                Route::post('/save_view', [AgentController::class, 'saveBookView']);
                Route::get('/get', [AgentController::class, 'getRecommended']);
            });

        });

        Route::prefix('cartitems')->controller(CartController::class)->group(function () {
            Route::get('/', 'getCartItems');
            Route::get('/{id}', 'getCartItems');
           Route::get('/total/cart', 'getCartTotal');
            Route::get('/user/cart', 'getUserCartItems');
            Route::post('/cart', [CartController::class, 'storeOrUpdate']);
            Route::delete('/delete/{cartItem}', 'destroy');
            Route::post('/decrease', [CartController::class, 'decreaseCartItem']);
        });


        Route::prefix('orders')->controller(OrderController::class)->group(function () {
            Route::get('orders', [OrderController::class, 'getOrders']);
            Route::get('orders/{id}', [OrderController::class, 'getOrders']);
            Route::get('users/{userId}', [OrderController::class, 'getUserOrders']);
            Route::post('/', [OrderController::class, 'storeOrUpdate']);
            Route::post('from-cart', [OrderController::class, 'createFromCart']);
            Route::post('{order}/cancel', [OrderController::class, 'cancel']);
            Route::delete('{order}', [OrderController::class, 'destroy']);
       


        });

        Route::group(["prefix" => "admin"], function () {
            Route::group(["middleware" => "isAdmin"], function () {
       
            });
        });

    });

    Route::group(["prefix" => "guest"], function () {
        Route::post("/login", [AuthController::class, "login"]);
        Route::post("/register", [AuthController::class, "register"]);

    });
});
