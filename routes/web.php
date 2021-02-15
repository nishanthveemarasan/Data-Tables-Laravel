<?php

use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/get', function () {
    return view('user');
});
Route::get('/getW', function () {
    return view('without');
});

Route::get('user/{fname?}', [ViewController::class, 'getCustomer'])->name('table');
Route::get('userTable', [ViewController::class, 'withoutDTable'])->name('table');

Route::get('users/{id?}', [ViewController::class, 'getUSerId'])->name('table');
