<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Usercontroller;


Route::get("/users", [UserController::class, "index"]);
