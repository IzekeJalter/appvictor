<?php

namespace App\Http\Controllers\Parque;

use App\Http\Controllers\Controller;
use App\Models\ModelosParque\Parque;
use App\Models\ModelosParque\Sensor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SensorController extends Controller
{
    public function addSensor(Request $request){
        $validacion = Validator::make(
            $request->all(),[
                'nombre_sensor' => "required|string|max:25",
                'feed_key'      => "required|string|max:25",
                'informacion'   => "required|string|max:300",
                'parque_id'     => "required|integer",
                'area_parque'   => "required|integer"
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

        $sensor = new Sensor();
        $sensor->nombre_sensor = $request->nombre_sensor;
        $sensor->feed_key = $request->feed_key;
        $sensor->informacion = $request->informacion;
        $sensor->parque_id = $request->parque_id;
        $sensor->area_parque = $request->area_parque;
        $sensor->save();

        if($sensor->save()){
            return response()->json([
                "status"        => 201,
                "msg"           => "Se insertaron datos de manera satisfactoria",
                "error"         => null,
                "data"          => $sensor
            ], 201);
        }
    }

    public function getAllSensores(Request $request){
        $validacion = Validator::make(
            $request->all(),[
                'id'                => "required"
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

        $parque = Parque::where('dueño_id', $request->id);
        return response()->json([
            "status"    => 200,
            "msg"       =>"Informacion localizada",
            "error"     => null,
            "data"      => Sensor::where('parque_id', $parque)->get()
        ],200);
        //Sensor::where('status', true)->get()
    }

    public function getSpecificSensor(Request $request){
        $validacion = Validator::make(
            $request->all(),[
                'id' => "required|interger"
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

        return response()->json([
            "status"    => 200,
            "msg"       =>"Informacion localizada",
            "error"     => null,
            "data"      => Sensor::where('id', $request->id)->get()
        ],200);
    }
}
