<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DcameronController;

Route::get('/hoteles', [DcameronController::class, 'index']);
Route::post('/hoteles', [DcameronController::class, 'store']);


