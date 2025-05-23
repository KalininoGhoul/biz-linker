<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Organization\OrganizationController;
use App\Http\Controllers\Organization\OrganizationProductsController;
use App\Http\Controllers\Organization\OrganizationWishlistController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);//->middleware('throttle:register');
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/my', [AuthController::class, 'me'])->middleware('auth:sanctum');

Route::prefix('my')->middleware('auth:sanctum')->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::post('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'delete']);

    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist', [WishlistController::class, 'store']);
    Route::put('/wishlist/{product}', [WishlistController::class, 'update']);
    Route::delete('/wishlist/{product}', [WishlistController::class, 'delete']);
});

Route::prefix('organizations')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [OrganizationController::class, 'index']);
    Route::get('/{organization}/products', OrganizationProductsController::class);
    Route::get('/{organization}/wishlist', OrganizationWishlistController::class);
    Route::get('/{organization}', [OrganizationController::class, 'show']);
});

Route::prefix('invoices')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [InvoiceController::class, 'index']);
    Route::post('/', [InvoiceController::class, 'store']);
    Route::put('/{invoice}/products', [InvoiceController::class, 'addProducts']);
    Route::delete('/{invoice}/products', [InvoiceController::class, 'removeProduct']);
    Route::get('/{invoice}', [InvoiceController::class, 'show']);
    Route::delete('/{invoice}', [InvoiceController::class, 'delete']);
});

Route::prefix('chats')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ChatController::class, 'index']);
    Route::post('/', [ChatController::class, 'store']);
    Route::get('/{chat}', [ChatController::class, 'show']);
    Route::delete('/{chat}', [ChatController::class, 'delete']);
    Route::post('/{chat}/messages/send', [MessageController::class, 'sendMessage']);
    Route::post('/{chat}/messages/pin', [MessageController::class, 'pinMessage']);
    Route::post('/{chat}/messages/unpin', [MessageController::class, 'unpinMessage']);
    Route::post('/{chat}/messages/delivered', [MessageController::class, 'delivered']);
});
