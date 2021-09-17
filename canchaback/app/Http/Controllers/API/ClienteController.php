<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($club_id)
    {
        //$club_id = $request->club_configuracion_id;

        //$clientes: consulta sql de los clientes pertenecientes a tal club
        $clientes = DB::table('cliente_club_configuracion')
                            ->join('clientes', 'cliente_club_configuracion.cliente_id', '=', 'clientes.id')
                            ->where('cliente_club_configuracion.club_configuracion_id', '=', $club_id)
                            ->select('clientes.*')
                            ->orderBy('id', 'asc')
                            ->get();

        return $clientes->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        //Valido datos con estas reglas
        $val = Validator::make($request->all(), [
            'nombre' => 'required|max:20',
            'apellido' => 'required',
            'edad' => 'required',
            'telefono' => 'required',
            'email' => 'required',
            'club_configuracion_id' => 'required',
        ]); 

        if($val->fails()){
            return response()->json([
                    'Respuesta' => 'Error', 
                    'Mensaje' => 'Faltan datos por rellenar']);
        }else { 
            try {
                DB::beginTransaction();

        //Valido que el email sea UNICO en la tabla clientes
        $val = Validator::make($request->all(), [
            'email' => 'required|unique:clientes',
            'club_configuracion_id' => 'required',
        ]); 

        //Si el email ya existe(fallo el validador), se agrega un registro en
        //la tabla "cliente_club_configuracion" (relacion M a M entre cliente y club)
        if($val->fails()){
            $cliente = Cliente::where('email', $request->email)->first();
            
            $sqlValidacionClienteClub = DB::table('cliente_club_configuracion')
                                                ->where([
                                                    ['cliente_club_configuracion.cliente_id', '=', $cliente->id],
                                                    ['cliente_club_configuracion.club_configuracion_id', '=', $request->club_configuracion_id],
                                                ])
                                                ->select('cliente_club_configuracion.*')
                                                ->get();
            //dd($sqlValidacionClienteClub);
                                
            //dd(count($sqlValidacionClienteClub));
            //dd($cliente->id);
            //dd($request->club_configuracion_id);

            
            //Verifico si ya esta registrado ese cliente y ese club
            if(count($sqlValidacionClienteClub) > 0){
                return response()->json([
                    'msj' => 'Error',
                    'razon' => 'Este cliente ya esta registrado!'
                ]);
            }else{
                //Si no hay registro en la tabla "cliente_club_configuracion", inserto uno nuevo 
                DB::table('cliente_club_configuracion')->insert([
                    'cliente_id' => $cliente->id,
                    'club_configuracion_id' => $request->club_configuracion_id,
                ]);
    
                return response()->json([
                    'msj' => 'Cliente ya registrado, vinculacion de club exitosa', 
                    'razon' => 'El cliente ya ha sido registrado por otra persona,
                                por lo tanto solo se registra al nuevo club que pertenece'
                ], 200);
            }  
        }else {
            //Si el email NO existe, se inserta un registro de un nuevo cliente en la tabla "clientes" 
            // y tambien se inserta un registro en la tabla "cliente_club_configuracion" del cliente y su club
            try {
                DB::beginTransaction(); 


                $cliente = Cliente::create([
                    "nombre" => $request->nombre,
                    "apellido" => $request->apellido,
                    "edad" => $request->edad,
                    "telefono" => $request->telefono,
                    "email" => $request->email,
                ]);

                DB::table('cliente_club_configuracion')->insert([
                    'cliente_id' => $cliente->id,
                    'club_configuracion_id' => $request->club_configuracion_id,
                ]);
  
                DB::commit(); 
            }
            // Ha ocurrido un error, devolvemos la BD a su estado previo
            catch (\Exception $e)
            {
                dd($e);
                DB::rollback();
                return response()->json(["Mensaje" => "Error!!"]);
            }


            return response()->json($cliente, 201);

            return response()->json([
                'msj' => 'Cliente creado exitosamente',
                'cliente' => $cliente
            ], 201);

        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $cliente_id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $club_id, $cliente_id)
    {
        //$club_id = $request->club_configuracion_id;

        $cliente = DB::table('cliente_club_configuracion')
                            ->join('clientes', 'cliente_club_configuracion.cliente_id', '=', 'clientes.id')
                            ->where('cliente_club_configuracion.club_configuracion_id', '=', $club_id)
                            ->where('clientes.id', '=', $cliente_id)
                            ->select('clientes.*')
                            ->get();

        return response()->json($cliente[0], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente, $cliente_id)
    {
        //dd($cliente_id);
        $cliente = Cliente::find($cliente_id);
        $cliente->update($request->all());
        return response()->json(['Petición' => 'Exitosa', 'Mensaje' => 'Cliente modificado']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente, $cliente_id)
    {
        Cliente::destroy($cliente_id);
        return response()->json(['Petición' => 'Exitosa', 'Mensaje' => 'Cliente eliminado']); 
    }
}
?>
