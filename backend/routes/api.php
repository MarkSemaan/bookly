<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;

Route::get('/greeting', function () {
    return 'Hello World';
});
Route::prefix('cartitems')->controller(CartController::class)->group(function () {
    Route::get('/', 'getCartItems'); 
    Route::get('/{id}', 'getCartItems'); 
    Route::get('/user/{userId}', 'getUserCartItems');
    Route::post('/', 'storeOrUpdate');
    Route::delete('/{cartItem}', 'destroy');
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
});


            //Customer APIs
        });

        Route::group(["prefix" => "admin"], function () {
            Route::group(["middleware" => "isAdmin"], function () {
                //Admin APIs
            });
        });

    });

    //UNAUTHENTICATED APIs
    Route::group(["prefix" => "guest"], function () {
    Route::post("/login", [AuthController::class, "login"]);
    Route::post("/register", [AuthController::class, "register"]);

    });
});