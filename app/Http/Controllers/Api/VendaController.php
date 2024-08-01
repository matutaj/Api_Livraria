<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venda;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\VendaRequest;
use App\Models\Livro;
use Exception;

class VendaController extends Controller
{
    //
    public function index(){
        $vendas = Venda::orderBy("id", "DESC")->get();

        return response()->json([
            "status"=> true,
            "vendas"=>$vendas,
        ], 200);
    }

    public function store(VendaRequest $request){
        DB::beginTransaction();

       // $valordoLivro =Livro::find($request->livroId); 
        try{
            $venda = Venda::create(
                $request->all(),
            );
            DB::commit();

            return response()->json([
                "status"=>true,
                "venda"=> $venda,
                "message"=>"Salvo com sucesso",
            ], 201);

        }catch( Exception $e){
            DB::rollBack();

            return response()->json([
                "status"=>false,
                "message"=>"Erro ao cadastrar a venda",
                "Error"=> $e->getMessage(),
            ], 400);
        }

    }
}
