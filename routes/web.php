<?php
use App\Http\Controllers\TryoutController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\PesertaController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    return view('landing-page');
});

Route::get('/wait', function () {
    if(Auth::user()->acc_verified_at != null){
        return redirect()->route('home');
    }
    return view('auth.wait-acc');
})->middleware('auth')->name('wait');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Laman verifikasi telah dikirim ke email anda!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::middleware(['auth','verified', 'acc.verified'])->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::resource('/tryout', 'TryoutController');
    Route::resource('/soal', 'QuestionController');
    Route::resource('/sesi', 'SesiController');
    Route::resource('/peserta', 'PesertaController');
    Route::resource('/bobot', 'BobotController');

    Route::get('/daftar-tunggu', [PesertaController::class, 'show_tunggu_acc'])->name('peserta.tunggu');

    Route::get('/ranking/{name}', [TryoutController::class, 'pemeringkatan'])->name('tryout.rank');

    Route::get('/tryout/{id}/peserta-list', [TryoutController::class, 'peserta_list'])->name('tryout.peserta');
    Route::get('/tryout/{id_tryout}/istirahat', [TryoutController::class, 'istirahat'])->name('tryout.istirahat');
    Route::get('/tryout/{id_tryout}/{no_soal}', [TryoutController::class, 'solve'])->name('tryout.soal');
    Route::get('/lembar/{id_tryout}/{id_peserta}', [TryoutController::class, 'lembar_jawaban'])->name('tryout.lembar');

    Route::post('/answer/submit', [AnswerController::class, 'submit_answer'])->name('answer.submit');

    //AJAX
    Route::post('/answer', [AnswerController::class, 'save_answer'])->name('answer.save');
    Route::post('/validate', [PesertaController::class, 'validate_acc'])->name('peserta.validate');

    //PDF Creator
    Route::get('/print/{type}/{id_tryout?}', 'PdfController@index')->name('cetak');
});
