<?php

namespace App\Http\Controllers\Parque;

use App\Http\Controllers\Controller;
use App\Models\ModelosParque\Parque;
use App\Models\ModelosParque\Sensor;
use App\Models\User;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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



        $response = Http::get("http://io.adafruit.com/api/v2/".config('global.important.userIO')."/groups/".config('global.important.group_key'), [
            'X-AIO-Key' => config('global.important.keyIO')
        ]);

        // $data = json_decode($response);
        $parque = Parque::where('dueño_id', $request->id);
        // $a = array('name', 'key');
        // $b = array(1, 2, 3, 4, 5);

        
        
        // dd(sizeof($data));
        if($response->successful()){
            // for ($i = 0; $i < sizeof($data); $i++) {
            //     return response()->json([
            //         'name' => $data->name,
            //         'key' => $data->name
            //     ]);
            // }
            // foreach($data as $lista){
            //     return $data;
            // }
            $longitud = sizeof($response->object()->feeds);
            // dd($longitud);
            // foreach ($data as $data['username']) {

            // }
            // dd($response->object()[5]->key);
            #dd($response->object()->feeds);

            foreach($response->object()->feeds as $feed){
                $names[] = $feed->name;
                $keys[] = $feed->key;
            }

            // for ($i = 0; $i < $longitud; $i++){
                
            // }

            // return $json;

            return response()->json([
                'name' => $names,
                'key'  => $keys
            ]);
            // for($i = 0; $i <= $longitud; $i++){
            //         $array = array($response->object()[$i]->name => 'name');
            //     }
            // dd($array);
            // return response()->json([
            //     'name'=>$response->object()[$i]->name
            // ]);
            // dd($carro);
        }else{
            return response()->json(['errors'=>$response]);
        }
        

    }
    public function getAllSensoresTry(Request $request){



        $response = Http::get("http://io.adafruit.com/api/v2/".config('global.important.userIO')."/feeds", [
            'X-AIO-Key' => config('global.important.keyIO')
        ]);

        $data = json_decode($response);
        $parque = Parque::where('dueño_id', $request->id);
        $a = array('name', 'key');
        $b = array(1, 2, 3, 4, 5);

        
        
        // dd(sizeof($data));
        if($response->successful()){
            // for ($i = 0; $i < sizeof($data); $i++) {
            //     return response()->json([
            //         'name' => $data->name,
            //         'key' => $data->name
            //     ]);
            // }
            // foreach($data as $lista){
            //     return $data;
            // }
            $longitud = count($data);
            // dd($longitud);
            // foreach ($data as $data['username']) {

            // }
            // dd($response->object()[5]->key);

            foreach($response->object() as $objeto){
                $names[] = $objeto->name;
                $keys[] = $objeto->key;
                $proyecto = $objeto->group_key;
            }
            dd($names, $keys);

            return $names;
            // for($i = 0; $i <= $longitud; $i++){
            //         $array = array($response->object()[$i]->name => 'name');
            //     }
            // dd($array);
            // return response()->json([
            //     'name'=>$response->object()[$i]->name
            // ]);
            // dd($carro);
        }else{
            return response()->json(['errors'=>$response]);
        }
        

    }

    public function getSpecificSensor(Request $request){
        $validacion = Validator::make(
            $request->all(),[
                'key' => "required|interger"
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
            "data"      => Sensor::where('feed_key', $request->key)->get()
        ],200);
    }
}
