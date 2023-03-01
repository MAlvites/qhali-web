<?php

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
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('users')->middleware('auth')->group(function () {
    Route::get('/', 'UserController@index');
    Route::post('create', 'UserController@create');
    Route::post('update', 'UserController@update');
    Route::post('search', 'UserController@search');
    Route::delete('{userId}', 'UserController@delete');
    Route::get('get-information/{userId}', 'UserController@getUser');    
    Route::get('get-bots', 'UserController@getBots');    
});

Route::prefix('patients')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('patient.index');
    });
    Route::get('/add', function () {
        return view('patient.create');
    });
    Route::get('/list', function () {
        return view('patient.list');
    });
    Route::get('/edit/{id}','PatientController@edit');
    Route::post('create', 'PatientController@create');
    Route::post('search', 'PatientController@search');
    Route::post('save-medical-history', 'PatientController@saveMedicalHistory');
    Route::get('generate-medical-history-pdf/{patientId}', 'PatientController@generateMedicalHistoryPdf');
    Route::post('update', 'PatientController@update');
});

Route::prefix('supports')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('support');
    });
    Route::post('send-mail', 'SupportMailController@sendMail');
});

Route::prefix('bot-actions')->middleware('auth')->group(function () {
    Route::get('/', 'BotActionController@index');
    Route::post('create', 'BotActionController@create');
    Route::post('search', 'BotActionController@search');
    Route::get('get/{botActionId}', 'BotActionController@getBotAction');
    Route::delete('{botActionId}', 'BotActionController@delete');
    Route::post('update', 'BotActionController@update');
    Route::get('get-all', 'BotActionController@getAll');
});

Route::prefix('bots')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('bot');
    });
});

Route::prefix('video')->middleware('auth')->group(function () {
    Route::post('video-chat', 'VideoChatController@auth');
});

Route::prefix('medical-appointments')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('medical-appointment.index');
    });
    Route::get('/patient-managment/{patientId}', 'MedicalAppointmentController@patientManagment');
    Route::get('/medical-attention/{patientId}/{botId}/{mapId}', 'MedicalAppointmentController@medicalAttention');
});

Route::prefix('quizzes')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('quiz.index');
    });
    Route::get('/add', function () {
        return view('quiz.create');
    });
    Route::get('/list', function () {
        return view('quiz.list');
    });
    Route::post('search', 'QuizController@search');
    Route::post('list', 'QuizController@list');
    Route::post('create', 'QuizController@create');
    Route::get('/{id}', 'QuizController@getQuiz');
    Route::get('/edit/{id}','QuizController@edit');
    Route::post('delete/{id}', 'QuizController@delete');
    Route::post('update', 'QuizController@update');
});

Route::prefix('patient-quizzes')->middleware('auth')->group(function () {
    Route::post('create', 'PatientQuizController@create');
    Route::post('search', 'PatientQuizController@search');
    Route::get('/{id}', 'PatientQuizController@getPatientQuiz');
    Route::post('relize-quiz', 'PatientQuizController@relizeQuiz');
});

Route::prefix('maps')->middleware('auth')->group(function () {
    Route::get('/', 'MapController@index');
    Route::post('create', 'MapController@create');
    Route::get('list', 'MapController@list');
    Route::post('search', 'MapController@search');
    Route::delete('/{id}', 'MapController@delete');
    Route::get('/{id}', 'MapController@getMap');
    Route::post('update', 'MapController@update');
});