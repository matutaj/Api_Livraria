<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $users = User::orderBy("id", "DESC")->paginate(2);

        return response()->json([
            "status"=>true,
            "users"=> $users,
        ], 200);
    }
}
