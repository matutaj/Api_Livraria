<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;
use Exception;

class CategoriaController extends Controller
{
    //

    public function index(){

        $categorias = Categoria::orderBy("id", "nome")->get();

        return response()->json([
            "status"=>true,
            "categorias"=> $categorias,
        ],200);

    }

    public function store(Request $request){

            DB::beginTransaction();

            try{
                $categoria = Categoria::create([
                    "nome"=>$request->nome,
                ]);

                DB::commit();

                return response()->json([
                    "status"=>true,
                    "message"=>"Salvo com sucesso",
                ],200);

            }catch(Exception $e){
                DB::rollBack();

                return response()->json([
                    "status"=>false,
                    "message"=>"Erro ao salvar a Categoria",
                ],400);
            }

    }
}
