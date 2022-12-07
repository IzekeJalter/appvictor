<?php

namespace App\Http\Controllers\Parque;

use App\Http\Controllers\Controller;
use App\Models\ModelosParque\Tarjeta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Builder\Use_;



class UsuarioController extends Controller
{
    public function crearDueño(Request $request){
        $validacion = Validator::make(
            $request->all(),[
                'nombre'        => "required|string|max:20",
                'apellidos'     => "required|string|max:30",
                'edad'          => "required|integer|min:1|max:120",
                'email'         => "required|string|unique:users|email",
                'contraseña'    => "required|string|min:4",
                'telefono'      => "required|integer",
                'apodo'         => "required|string|max:20"
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

        $tarjeta = new Tarjeta();
        $tarjeta->save();

        $user = new User();
        $user->nombre           = $request->nombre;
        $user->apellidos        = $request->apellidos;
        $user->edad             = $request->edad;
        $user->email            = $request->email;
        $user->contraseña       = bcrypt($request->contraseña);
        $user->telefono         = $request->telefono;
        $user->apodo            = $request->apodo;
        $user->numero_tarjeta   = $tarjeta->id;
        $user->save();

        if($user->save()){
            return response()->json([
                "status"        => 201,
                "msg"           => "Se ha registrado de manera satisfactoria",
                "error"         => null,
                "data"          => $user
            ], 201);
        }else{
            return response()->json([
                "msg"   =>  "Existe un error al registrar el usuario, por favor verifique que sea la informacion adecuada"
            ]);
        }




    }
}
