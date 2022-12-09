<?php

namespace App\Http\Controllers\Parque;

use App\Http\Controllers\Controller;
use App\Models\ModelosParque\Parque;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParqueController extends Controller
{
    public function addParque(Request $request){
        $validacion = Validator::make(
            $request->all(),[
                'nombre'                => "required|string|max:25",
                'reglas'                => "required|string|max:1000",
                'medida_largoTerreno'   => "required|integer",
                'medida_anchoTerreno'   => "required|integer",
                'cantidad_sensores'     => 'required|integer',
                'cantidad_entradas'     => 'required|integer',
                'cantidad_salidas'      => 'required|integer'
            ]
        );
        if($validacion->fails()){
            return response()->json([
                "status"    => 400,
                "msg"       => "No se cumplieron las validaciones",
                "error"     => $validacion->errors(),
                "data"      => null
            ], 400);
        }

        $parque = new Parque();
        $parque->nombre = $request->nombre;
        $parque->dueño_id = $request->url();
        $parque->reglas = $request->reglas;
        $parque->medida_largoTerreno = $request->medida_largoTerreno;
        $parque->medida_anchoTerreno = $request->medida_anchoTerreno;
        $parque->cantidad_sensores = $request->cantidad_sensores;
        $parque->cantidad_entradas = $request->cantidad_entradas;
        $parque->cantidad_salidas = $request->cantidad_salidas;
        $parque->save();

        if($parque->save()){
            return response()->json([
                "status"        => 201,
                "msg"           => "Se insertaron datos de manera satisfactoria",
                "error"         => null,
                "data"          => $parque
            ], 201);
        }
    }

    public function getAllParques(){
        return response()->json([
            "status"=>200,
            "msg"=>"Informacion localizada",
            "error"=>null,
            // "data"=>Persona::all()
            "data"=>Parque::where('status', true)->get()
        ],200);
    }
}
