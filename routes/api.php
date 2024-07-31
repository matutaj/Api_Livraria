<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Usercontroller;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RecuperarSenhaController;
use App\Http\Controllers\Api\LivroController;

//Rota Login
Route::post('/login', [LoginController::class, "login"])->name("login");

//Recuperar a Senha de Usuário
Route::post("/forgot-password-code", [RecuperarSenhaController::class, "forgotPasswordCode"]);
//rota para validar se o código de confirmalção está correto.
Route::post("/reset-password-validate-code",[RecuperarSenhaController::class,"resetPasswordValidatecode"]);
//Rota para atualizar os dados do Usuário
Route::post("/reset-password-code", [RecuperarSenhaController::class. "resetPasswordCode"]);

//Rotas do Usuário
Route::get("/users", [UserController::class, "index"]); //Traz todos os dados de forma paginada
Route::get("/users/{user}", [UserController::class, "show"]);// Lista ou apresenta apenas o usuário pelo o Id do usuário.
Route::post("/users", [UserController::class, "store"]);
Route::put("/users/{user}", [UserController::class, "update"]);

//Rotas da Categoria
Route::get("/categorias",[CategoriaController::class, "index"]);
Route::post("/categorias", [CategoriaController::class, "store"]);
Route::put("/categorias/{categoria}",[CategoriaController::class, "update"]); 


//Permissão de acesso
/*Route::middleware("auth:sanctum")->group(
    function(){
        Route::get("/categorias",[CategoriaController::class, "index"]);
        Route::post("/categorias", [CategoriaController::class, "store"]);
        Route::put("/categorias/{categoria}",[CategoriaController::class, "update"]); 
    }
);*/

// Rotas para livro
Route::post("/livro",[LivroController::class, "store"]);
Route::get("/livro",[LivroController::class, "index"]);
Route::put("/livro/{id}", [LivroController::class, "update"]);