<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venda;

class VendaController extends Controller
{
    //
    public function index(){
        $vendas = Venda::ordeBy("id", "DESC")->get();

        return response()->json([
            "status"=> true,
            "vendas"=>$vendas,
        ], 200);
    }
}
