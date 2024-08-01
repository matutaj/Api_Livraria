<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venda;
use Illuminate\support\Facades\DB;
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

    public function store(Request $request){
        DB::beginTransaction();

        try{
            $venda = Venda::create($request->all());
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
