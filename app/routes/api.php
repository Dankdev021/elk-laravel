<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

Route::post('/clientes', [ClienteController::class, 'store']);
Route::put('/clientes/{id}', [ClienteController::class, 'update']);
