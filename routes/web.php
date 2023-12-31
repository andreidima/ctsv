<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RecoltareSangeController;
use App\Http\Controllers\RecoltareSangeIntrareController;
use App\Http\Controllers\RecoltareSangeComandaController;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\RecoltareSangeValidareController;
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

Auth::routes(['register' => false, 'password.request' => false, 'reset' => false]);


Route::redirect('/', '/acasa');

Route::group(['middleware' => 'auth'], function () {
    Route::view('/acasa', 'acasa');

    Route::get('/recoltari-sange/rebuturi', [RecoltareSangeController::class, 'rebuturi']);
    Route::get('/recoltari-sange/rebuturi/modifica/{recoltareSange}', [RecoltareSangeController::class, 'rebuturiModifica']);
    Route::patch('/recoltari-sange/rebuturi/modifica/{recoltareSange}', [RecoltareSangeController::class, 'postRebuturiModifica']);

    Route::resource('/recoltari-sange/intrari', RecoltareSangeIntrareController::class)->parameters(['intrari' => 'recoltareSangeIntrare']);

    Route::resource('/recoltari-sange/comenzi', RecoltareSangeComandaController::class)->parameters(['comenzi' => 'recoltareSangeComanda']);
    Route::get('/recoltari-sange/comenzi/{recoltareSangeComanda}/{view_type}', [RecoltareSangeComandaController::class, 'exportPdf']);

    Route::resource('/recoltari-sange', RecoltareSangeController::class)->parameters(['recoltari-sange' => 'recoltareSange']);

    Route::get('/rapoarte', [RaportController::class, 'index']);
    Route::get('/rapoarte/stocuri-pungi-sange', [RaportController::class, 'stocuriPungiSange']);
    Route::get('/rapoarte/stocuri-pungi-sange/export-pdf', [RaportController::class, 'stocuriPungiSangeExportPdf']);

    // Validarea recoltarilor de sange ce ajung in laborator
    Route::get('/recoltari-sange-validare-inregistrari-in-laborator', [RecoltareSangeValidareController::class, 'validare']);
    Route::post('/recoltari-sange-validare-inregistrari-in-laborator/axios-cauta-punga', [RecoltareSangeValidareController::class, 'axiosCautaPunga']);
    Route::post('/recoltari-sange-validare-inregistrari-in-laborator/valideaza-invalideaza-punga', [RecoltareSangeValidareController::class, 'axiosValideazaInvalideazaPunga']);
    Route::post('/recoltari-sange-validare-inregistrari-in-laborator/modifica-rebut-punga', [RecoltareSangeValidareController::class, 'axiosModificaRebutPunga']);
});

