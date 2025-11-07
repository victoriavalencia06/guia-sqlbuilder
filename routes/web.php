<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueryController;

Route::get('/ej2_qb', [QueryController::class, 'ej2_qb']);
Route::get('/ej2_eq', [QueryController::class, 'ej2_eloquent']);
Route::get('/ej3_qb', [QueryController::class, 'ej3_qb']);
Route::get('/ej4_qb', [QueryController::class, 'ej4_qb']);
Route::get('/ej5_qb', [QueryController::class, 'ej5_qb']);
Route::get('/ej6_qb', [QueryController::class, 'ej6_qb']);
Route::get('/ej7_qb', [QueryController::class, 'ej7_qb']);
Route::get('/ej8_qb', [QueryController::class, 'ej8_qb']);
Route::get('/ej9_qb', [QueryController::class, 'ej9_qb']);
Route::get('/ej10_qb', [QueryController::class, 'ej10_qb']);

Route::get('/', function () {
    return view('welcome');
});
