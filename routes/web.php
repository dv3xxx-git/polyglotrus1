<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParseController;

Route::get('/', function () {
    return view('welcome');
});

// для тестов, потому убрать в команду вдруг еще нужно будет
Route::get('/test', [ParseController::class, 'parseWordByWord']);
