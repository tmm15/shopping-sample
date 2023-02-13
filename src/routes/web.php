<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ConrtactController;

use Illuminate\Http\Request;


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

Route::get('/keyword', [ConrtactController::class, 'index']);
Route::get('/keyword', [ConrtactController::class, 'index']);
Route::get('/keyword', [ConrtactController::class, 'index']);



Route::get('/price/{price}/{page?}', [ConrtactController::class, 'price']);
Route::get('/genre/{genre}/{page?}', [ConrtactController::class, 'genre']);

// Route::post('/cookie', function (Request $request) {
//     // cookieを新たに発行する
//     Cookie::queue('keyword', $request->search, 1);

//     // cookie.blade.phpへリダイレクト
//     return redirect('/cookie');
// });