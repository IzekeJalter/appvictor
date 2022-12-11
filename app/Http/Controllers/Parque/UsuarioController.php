<?php

namespace App\Http\Controllers\Parque;

use App\Http\Controllers\Controller;
use App\Jobs\processSMS;
use App\Models\ModelosParque\Tarjeta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
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
                'username'      => "required|string|max:20"
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

        srand (time());
        $numero_aleatorio= rand(5000,6000);

        $user = new User();
        $user->nombre           = $request->nombre;
        $user->apellidos        = $request->apellidos;
        $user->edad             = $request->edad;
        $user->email            = $request->email;
        $user->contraseña       = bcrypt($request->contraseña);
        $user->telefono         = $request->telefono;
        $user->username         = $request->username;
        $user->codigo           = $numero_aleatorio;
        $user->numero_tarjeta   = $tarjeta->id;
        $user->save();

//        $valor=$user->id;
  //      $url= URL::temporarySignedRoute(
    //     'validarnumero', now()->addMinutes(30), ['url' => $valor]);

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
    Public function numerodeverificacionmovil(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(401,"EL CODIGO ES INCORRECTO");
        }
        srand (time());
        
     $numero_aleatorio2 = rand(5000,6000);
     $numeroiddelaurl= $request->url;


          $url= URL::temporarySignedRoute(
            'telefonoregistr', now()->addMinutes(30), ['url' => $numero_aleatorio2]
        );
        $user = User::where('id', $numeroiddelaurl )->first();

        processSMS::dispatch($user, $url)->onQueue('processSMS')->onConnection('database')->delay(now()->addSeconds(10));

        //   processVerify::dispatch($user, $url)->onQueue('processVerify')->onConnection('database')->delay(now()->addSeconds(15));

        return response()->json([
            "msg"=>"Tu numero de verificacion a sido enviada a tu telefono, 
            en breve recibiras un correo con instrucciones.",
    
        ],201);
    }
}