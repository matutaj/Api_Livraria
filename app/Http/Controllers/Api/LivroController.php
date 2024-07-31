<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Livro;
use App\Http\Requests\LivroRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;
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

    public function store(LivroRequest $request){
        DB::beginTransaction();
        
        try{

            $livro = Livro::create($request->all());
            DB::commit();

            return response()->json([
                "status"=>true,
                "livro"=>$livro,
                "message"=> "Salvo com sucesso",
            ], 201);
            
        }catch(Exception $e){
            DB::rollBack();

            return response()->json([
                "status"=>false,
                "message"=>"Erro ao salvar o livro",
                "errors"=> $e->getMessage(),
            ], 400);
        }
    }
    public function update(Request $request, $id){
        DB::beginTransaction();

        try{
            $updateLivro = $request->all();

            Livro::find( $id)->update($updateLivro);
            DB::commit();
            return response()->json([
                "status"=> true,
                "livro"=> $updateLivro,
                "message"=> "O Livro foi atualizado com sucesso",
            ], 200);
        }catch(Exception $e){
            DB::rollBack();

            return response()->json([
                "status"=>false,
                "message"=> "Livro não foi atualizado",
                "errors"=> $e->getMessage(),
            ],400);
        }
    }
}
