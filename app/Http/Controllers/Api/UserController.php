<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        //Pegando os usuários do banco de dados
        $users = User::orderBy("id", "DESC")->paginate(2);

        //Retornando os dados como JSON
        return response()->json([
            "status"=>true,
            "users"=> $users,
        ], 200);
    }

    public function show(User $user){
        return response()->json([
            "status"=>true,
            "user"=> $user,
        ], 200);
    }
}
