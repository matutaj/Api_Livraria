<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Usercontroller;
use App\Http\Controllers\Api\CategoriaController;

//Rotas do Usuário
Route::get("/users", [UserController::class, "index"]); //Traz todos os dados de forma paginada
Route::get("/users/{user}", [UserController::class, "show"]);// Lista ou apresenta apenas o usuário pelo o Id do usuário.
Route::post("/users", [UserController::class, "store"]);
Route::put("/users/{user}", [UserController::class, "update"]);

//Rotas da Categoria
Route::post("/categorias", [CategoriaController::class, "store"]);
Route::get("/categorias",[CategoriaController::class, "index"]);
Route::put("/categorias/{categoria}",[CategoriaController::class, "update"]);