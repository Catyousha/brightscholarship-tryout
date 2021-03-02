<?php
use App\Http\Controllers\TryoutController;
use App\Http\Controllers\AnswerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
    if(Session::has('ongoing_tryout')){
        $id = Session::get('ongoing_tryout');
        return redirect()->route('tryout.soal', ['id_tryout'=>$id, 'no_soal'=>1]);
    }

    return view('welcome');
});

Route::middleware('auth')->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::resource('/tryout', 'TryoutController');
    Route::resource('/soal', 'QuestionController');
    Route::resource('/sesi', 'SesiController');
    Route::resource('/peserta', 'PesertaController');
    Route::resource('/bobot', 'BobotController');

    Route::get('/ranking/{name}', [TryoutController::class, 'pemeringkatan'])->name('tryout.rank');

    Route::get('/tryout/{id}/peserta-list', [TryoutController::class, 'peserta_list'])->name('tryout.peserta');
    Route::get('/tryout/{id_tryout}/istirahat', [TryoutController::class, 'istirahat'])->name('tryout.istirahat');
    Route::get('/tryout/{id_tryout}/{no_soal}', [TryoutController::class, 'solve'])->name('tryout.soal');
    Route::get('/lembar/{id_tryout}/{id_peserta}', [TryoutController::class, 'lembar_jawaban'])->name('tryout.lembar');

    Route::post('/answer/submit', [AnswerController::class, 'submit_answer'])->name('answer.submit');

    //AJAX
    Route::post('/answer', [AnswerController::class, 'save_answer'])->name('answer.save');

    //PDF Creator
    Route::get('/print/{type}', 'PdfController@index')->name('print');

});

Route::get('/blank', function () {
    return view('blank');
})->name('blank');
