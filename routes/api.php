<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Usercontroller;
use App\Htpp\Controllers\Api\CategoriaController;

//Rotas do Usuário
Route::get("/users", [UserController::class, "index"]); //Traz todos os dados de forma paginada
Route::get("/users/{user}", [UserController::class, "show"]);// Lista ou apresenta apenas o usuário pelo o Id do usuário.
Route::post("/users", [UserController::class, "store"]);
Route::put("/users/{user}", [UserController::class, "update"]);

//Rotas da Categoria
Route::post("/categoria", [CategoriaController::class, "store"]);
