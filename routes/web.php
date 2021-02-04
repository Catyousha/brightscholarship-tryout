<?php
use App\Http\Controllers\TryoutController;
use App\Http\Controllers\AnswerController;
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

Route::middleware('auth')->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::get('/tryout/{id_tryout}/{no_soal}', [TryoutController::class, 'show'])->name('tryout.soal');
    Route::post('/answer/submit', [AnswerController::class, 'submit_answer'])->name('answer.submit');

    //AJAX
    Route::post('/answer', [AnswerController::class, 'save_answer'])->name('answer.save');

});

Route::get('/blank', function () {
    return view('blank');
})->name('blank');
