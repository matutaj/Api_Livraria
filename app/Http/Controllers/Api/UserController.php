<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Response;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResponse;

class UserController extends Controller
{
    public function index(){
        //Pegando os usuários do banco de dados
        $users = User::orderBy("id", "DESC")->get();

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

    public function store(UserRequest $request){

        //iniciar a transação
        DB::beginTransaction();

        try{
    $user =  User::create([
                "name"=> $request->name,
                "email"=> $request->email,
                "password"=>$request->password,
            ]);

            //confirma o registro no banco
            DB::commit();

          return  response()->json([
                "status"=>true,
                "message"=> "Salvo com sucesso!",
            ],201);

        }catch( Exception $e){
            //Operação não salva com êxito no banco
            DB::rollBack();

            //Retorna uma mensagem de erro com status 400

            return response()->json([
                "status"=> false,
                "message"=>"Erro ao salvar os dados",
            ], 400);
        }
       
    }

    public function update(UserRequest $request,  User $user){
        return response()->json([
            "status"=> true,
            "user"=>$request,
            "message"=>"Usuário Editado com sucesso"
        ], 200);
    }
}
