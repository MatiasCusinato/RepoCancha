<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($club_id, $registros=null, Request $request)
    {
        if($registros==null){
            $clientes = DB::table('cliente_club_configuracion')
                            ->join('clientes', 'cliente_club_configuracion.cliente_id', '=', 'clientes.id')
                            ->where('cliente_club_configuracion.club_configuracion_id', '=', $club_id)
                            ->select('clientes.*')
                            ->orderBy('clientes.id', 'asc')
                            ->get();

            if($clientes->isEmpty()){
                return response()->json([
                    "msj" => "Error",
                    "razon" => "Este club no tiene clientes por ahora",
                ], 400);
            }   

            $registros = count($clientes);
        }

        $clientes = DB::table('cliente_club_configuracion')
                            ->join('clientes', 'cliente_club_configuracion.cliente_id', '=', 'clientes.id')
                            ->where('cliente_club_configuracion.club_configuracion_id', '=', $club_id)
                            ->select('clientes.*')
                            ->orderBy('id', 'desc')
                            ->paginate($registros);

        return [
            'paginacion' => [
                'total'         => $clientes->total(),
                'current_page'  => $clientes->currentPage(),
                'per_page'      => $clientes->perPage(),
                'last_page'     => $clientes->lastPage(),
                'from'          => $clientes->firstItem(),
                'to'            => $clientes->lastPage(),
            ],

            'clientes' => $clientes
        ];

        //$club_id = $request->club_configuracion_id;

        //$clientes: consulta sql de los clientes pertenecientes a tal club
        
        //return $clientes->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Valido que el email sea UNICO en la tabla clientes
        $val = Validator::make($request->all(), [
            'email' => 'required|unique:clientes|max:50',
            'club_configuracion_id' => ['required', 'exists:club_configuracions,id'],
            'nombre' => ['required', 'max:30'],
            'apellido' => ['required', 'max:30'],
            'telefono' => ['required', 'max:30'],
            'edad' => ['required'],
        ]); 

        //Si el email ya existe(falló el validador), se agrega un registro en
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
                            ->select('clientes.*', 'cliente_club_configuracion.club_configuracion_id')
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
    public function update(Request $request, Cliente $cliente, $club_id, $cliente_id)
    {
        $val = Validator::make($request->all(), [
            'email' => 'required|max:50',
            'club_configuracion_id' => ['required', 'exists:club_configuracions,id'],
            'nombre' => ['required', 'max:30'],
            'apellido' => ['required', 'max:30'],
            'telefono' => ['required', 'max:30'],
            'edad' => ['required'],
        ]); 

        if($val->fails()){
            return response()->json([
                    'msj' => 'Error', 
                    'razon' => 'Falta uno de los datos, o algun campo sobrepasa los caracteres maximos(50 email, 30 los demas campos).'
            ], 400);
        }else { 
            try {
                DB::beginTransaction();

                //dd($cliente_id);    
                $cliente = Cliente::find($cliente_id);
                $cliente->update($request->all());

                DB::commit(); 
            }
            // Ha ocurrido un error, devolvemos la BD a su estado previo
            catch (\Exception $e)
            {
                dd($e);
                DB::rollback();
                return response()->json(["msj" => "Error!!, rollback"], 400);
            }
            
            return response()->json([
                'msj' => 'Modificacion exitosa',
                'razon' => 'El cliente ha sido modificado'
            ], 200);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($club_id, $cliente_id, Cliente $cliente, Request $request)
    {   
        $club = DB::table('club_configuracions')
                    ->select('club_configuracions.id')
                    ->where('club_configuracions.id', '=', $club_id)
                    ->get();

        if($club->isEmpty()){
            return response()->json([
                'msj' => 'Error',
                'razon' => 'El club especificado no existe'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $existeCliente= DB::table('cliente_club_configuracion')
                                ->where([
                                    ['cliente_id', '=', $cliente_id],
                                ])
                                ->get();

            if($existeCliente->isEmpty()){
                DB::table('clientes')
                    ->where([
                        ['id', '=', $cliente_id],
                    ])
                    ->delete();

                return response()->json([
                    'msj' => 'Exitosa',
                    'razon' => 'Cliente eliminado de la bd'
                ], 200);
            } else {
                $vinculacionClienteClub= DB::table('cliente_club_configuracion')
                                                ->where([
                                                    ['cliente_id', '=', $cliente_id],
                                                    ['club_configuracion_id', '=', $club_id],
                                                ])
                                                ->get();
                                                
                if($vinculacionClienteClub->isEmpty()){
                    return response()->json([
                        'msj' => 'Error',
                        'razon' => 'El cliente no esta registrado o ya ha sido borrado'
                    ], 200);
                } else{
                    DB::table('cliente_club_configuracion')
                        ->where([
                            ['cliente_id', '=', $cliente_id],
                            ['club_configuracion_id', '=', $club_id],
                        ])
                        ->delete();
                }
            }

                

            DB::commit(); 
        }
        // Ha ocurrido un error, devolvemos la BD a su estado previo
        catch (\Exception $e)
        {
            dd($e);
            DB::rollback();
            return response()->json(["msj" => "Error!!, rollback"], 400);
        }
        
        
    
    }

    public function filtroNombre($club_id, $nombre, Request $request){
        $clientes = DB::table('cliente_club_configuracion')
                            ->join('clientes', 'cliente_club_configuracion.cliente_id', '=', 'clientes.id')
                            ->where([
                                ['cliente_club_configuracion.club_configuracion_id', '=', $club_id],
                                ['clientes.nombre', 'like', '%' . $nombre . '%'],
                            ])
                            ->select('clientes.*')
                            ->get();

        return response()->json([
            'Petición' => 'Filtrado Exitoso',
            'clientes' => $clientes
        ], 200);
    }
}
?>
