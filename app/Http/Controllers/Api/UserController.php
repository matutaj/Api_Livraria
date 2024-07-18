<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class UserController extends Controller
{
    public function index() :JsonReponse{
        //Pegando os usuários do banco de dados
        $users = User::orderBy("id", "DESC")->paginate(2);

        //Retornando os dados como JSON
        return response()->json([
            "status"=>true,
            "users"=> $users,
        ], 200);
    }
}
