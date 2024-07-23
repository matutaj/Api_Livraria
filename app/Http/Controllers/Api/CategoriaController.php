<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Exception;

class CategoriaController extends Controller
{
    //

    public function index(){

        $categorias = Categoria::orderBy("id", "DESC")->get();

        return response()->json([
            "status"=>true,
            "categorias"=> $categorias,
        ],200);

    }

    public function store(CategoriaRequest $request){

            DB::beginTransaction();

            try{
                $categoria = Categoria::create([
                    "nome"=>$request->nome,
                ]);

                DB::commit();

                return response()->json([
                    "status"=>true,
                    "message"=>"Salvo com sucesso",
                ],201);

            }catch(Exception $e){
                DB::rollBack();

                return response()->json([
                    "status"=>false,
                    "message"=>"Erro ao salvar a Categoria",
                ],400);
            }

    }
}