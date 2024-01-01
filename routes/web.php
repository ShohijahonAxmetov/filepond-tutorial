<?php

use App\Http\Controllers\FilePondController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Filepond routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'filepond'], function () {
    Route::post('process', [FilePondController::class, 'process']);
    Route::delete('revert', [FilePondController::class, 'revert']);
    Route::get('load', [FilePondController::class, 'load']);
    Route::post('remove', [FilePondController::class, 'remove']);
});


/*
|--------------------------------------------------------------------------
| Show Form data
|--------------------------------------------------------------------------
*/
Route::post('file/save', function (\Illuminate\Http\Request $request) {
    dd($request->all());
})->name('file.save');


/*
|--------------------------------------------------------------------------
| Show session list
|--------------------------------------------------------------------------
*/
Route::get('session-test', function () {
    return response(session('files'));
});
