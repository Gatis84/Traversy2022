<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//show all Listings
Route::get('/', [\App\Http\Controllers\ListingController::class, 'index']);

//show Create form
Route::get('/listings/create', [\App\Http\Controllers\ListingController::class, 'create'])
    ->middleware('auth');

//store listing data
Route::post('/listings', [\App\Http\Controllers\ListingController::class, 'store'])
    ->middleware('auth');

//Manage Listings
Route::get('/listings/manage', [\App\Http\Controllers\ListingController::class, 'manage'])
    ->middleware('auth');

// Single Listing
Route::get('/listings/{listing}', [\App\Http\Controllers\ListingController::class, 'show']);

//show edit form
Route::get('/listings/{listing}/edit', [\App\Http\Controllers\ListingController::class, 'edit'])
    ->middleware('auth');

// Update Listing

Route::put('/listings/{listing}', [\App\Http\Controllers\ListingController::class,'update'])
    ->middleware('auth');

// Delete Listing
Route::delete('/listings/{listing}', [\App\Http\Controllers\ListingController::class,'destroy'])
    ->middleware('auth');

// Show Register/create form

Route::get('/register', [UserController::class, 'create'])
    ->middleware('guest');

// Create New User

Route::post('/users', [UserController::class, 'store']);

//log user out

Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth');

//show login form

Route::get('/login', [UserController::class,'login'])
    ->name('login')
    ->middleware('guest');

//log in user

Route::post('/users/authenticate', [UserController::class,'authenticate']);

Route::get('/posts/{id}', function ($id) {
    return response('Post ' . $id);
})->where('id', '[0-9]+');

Route::get('/search', function (\Illuminate\Http\Request $request) {
    dd($request->name . ' ' . $request->city);
});

