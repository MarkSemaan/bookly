<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgentController;


Route::get('/greeting', function () {
    return 'Hello World';
});




Route::group(["prefix" => "v0.1"], function () {
    Route::group(["middleware" => "auth:api"], function () {
        //AUTHENTICATED APIs


        Route::group(["prefix" => "user"], function () {
            Route::prefix('books')->group(function () {
                Route::post('/', [BookController::class, 'storeOrUpdate']);
                Route::get('/', [BookController::class, 'getBooks']);
                Route::get('/{id}', [BookController::class, 'getBookById']);
                Route::delete('/{id}', [BookController::class, 'deleteBook']);

                Route::group(["prefix" => "ai_support"], function () {
                    //APIs for ai
                    Route::post('/save_search', [AgentController::class, 'saveSearch']);
                    Route::post('/save_view', [AgentController::class, 'saveView']);
                });



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