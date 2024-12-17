<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\JournalController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth', 'prefix' => 'clients'], function () {
    Route::get('/', [ClientsController::class, 'index'])->name('clients.index');
    Route::get('/create', [ClientsController::class, 'create'])->name('clients.create');
    Route::post('/', [ClientsController::class, 'store'])->name('clients.store');
    Route::get('/{client}', [ClientsController::class, 'show'])->name('clients.show');
    Route::delete('/{client}', [ClientsController::class, 'destroy'])->name('clients.destroy');

    Route::get('/{client}/journals', [JournalController::class, 'index'])->name('journals.index');
    Route::post('/{client}/journals', [JournalController::class, 'store'])->name('journals.store');
    Route::delete('/{client}/journals/{journal}', [JournalController::class, 'destroy'])->name('journals.destroy');
});
