<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Livro;
use Illuminate\Support\Facades\DB;
use Exception;

class LivroController extends Controller
{
    //
    public function index(){
        $livros = Livro::orderBy("id", "DESC")->get();

        return response()->json([
            "status"=>true,
            "livros"=> $livros
        ],200);
    }

    public function store(Request $request){
        DB::beginTransaction();

        try{
            $livro = Livro::create([
                "nome"=>$request->nome,
                "descricao"=>$request->descricao,
                "preco"=>$request->preco,
                "edicao"=>$request->edicao,
                "autor"=>$request->autor,
                "dataLancamente"=>$request->dataLancamento,
                "quantidade"=>$request->quantidade,
                "imagem"=>$request->imagem,
            ]);
            DB::commit();

            return response()->json([
                "status"=>true,
                "message"=> "Salvo com sucesso",
            ], 201);
        }catch( Exception $e){
            DB::rollBack();

            return response()->json([
                "status"=>false,
                "message"=>"Erro ao salvar o livro",
            ], 400);
        }
    }
}
