<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Usercontroller;


Route::get("/users", [UserController::class, "index"]); //Traz todos os dados de forma paginada
Route::get("/users/{user}", [UserController::class, "show"]);// Lista ou apresenta apenas o usuário pelo o Id do usuário.
Route::post("/users", [UserController::class, "store"]);
