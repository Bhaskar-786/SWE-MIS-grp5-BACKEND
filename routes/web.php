<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\makeController;
use App\Http\Controllers\nameController;

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
Route::get('/login', function () {
    echo "hii";
});



Route::post('add', [GradeController::class, 'addGrade']);
Route::post('sync-and-update', [GradeController::class, 'updateUserStatus']);
Route::post('reinstate', [GradeController::class, 'reinstate']);
Route::get('hello', [GradeController::class, 'hello']);
Route::get('abc', [GradeController::class, 'abc']);
Route::get('test', [GradeController::class, 'testConnection']);



Route::controller(AdminController::class)->group(function () {
    //  Route::get('test', 'test'); 
});



// Route::resource('name', [nameController::class]);
// Route::resource('add', [makeController::class]);
// Route::resource('sync-and-update', [GradeController::class, 'updateUserStatus']);