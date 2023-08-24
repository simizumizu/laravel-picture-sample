<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PictureController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PictureController::class, 'index'])->name('picture.index');
Route::get('/create', [PictureController::class, 'create'])->name('picture.create');
Route::post('/store', [PictureController::class, 'store'])->name('picture.store');
