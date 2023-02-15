<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('authenticate')->group(function () {
    Route::get('user', 'AuthenticateController@getUser')->middleware('auth:sanctum');
    Route::post('login', 'AuthenticateController@login');
    Route::get('logout', 'AuthenticateController@logout')->middleware('auth:sanctum');
    Route::post('send-password-reset-email', 'AuthenticateController@sendPasswordResetEmail');
    Route::post('change-password', 'AuthenticateController@changePassword');
});

Route::prefix('users')->middleware('auth:sanctum')->group(function () {
    Route::post('create', 'UserController@create');
    Route::get('list', 'UserController@list');
    Route::get('get/{id}', 'UserController@getUser');
    Route::delete('{id}', 'UserController@delete');
    Route::post('update', 'UserController@update');
});

Route::prefix('patients')->group(function () {
    Route::post('create', 'PatientController@create')->middleware('auth:sanctum');
    Route::get('list', 'PatientController@list')->middleware('auth:sanctum');
    Route::post('save-medical-history', 'PatientController@saveMedicalHistory')->middleware('auth:sanctum');
    Route::get('generate-medical-history-pdf/{patientId}', 'PatientController@generateMedicalHistoryPdf');
    Route::get('get/{id}', 'PatientController@getPatient')->middleware('auth:sanctum');;
    Route::post('update', 'PatientController@update')->middleware('auth:sanctum');
});

Route::prefix('support')->middleware('auth:sanctum')->group(function () {
    Route::post('send-mail', 'SupportMailController@sendMail');
});

Route::prefix('bot-actions')->middleware('auth:sanctum')->group(function () {
    Route::post('create', 'BotActionController@create');
    Route::get('list', 'BotActionController@list');
    Route::get('get/{botActionId}', 'BotActionController@getBotAction');
    Route::delete('{botActionId}', 'BotActionController@delete');
    Route::post('update', 'BotActionController@update');
    Route::get('get-all', 'BotActionController@getAll');
});

Route::prefix('video')->middleware('auth:sanctum')->group(function () {
    Route::post('video-chat', 'VideoChatController@auth');
});