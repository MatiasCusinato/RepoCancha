<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Turno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class TurnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($club_id, $cancha_id)
    {
        $turnos = DB::table('turnos')
                    ->join('clientes', 'turnos.cliente_id', '=', 'clientes.id')
                    ->join('canchas', 'turnos.cancha_id', '=', 'canchas.id')
                        ->where([
                            ['turnos.club_configuracion_id', '=', $club_id],
                            ['turnos.cancha_id', '=', $cancha_id],
                        ])
                            ->select('turnos.id', 'turnos.grupo', 'turnos.cliente_id',
                                        'clientes.nombre', 'clientes.apellido',
                                        'turnos.cancha_id', 'canchas.deporte',
                                        'turnos.club_configuracion_id',
                                        'turnos.tipo_turno', 'turnos.fecha_Desde',
                                        'turnos.fecha_Hasta', 'turnos.precio',)
                            ->get();

        return $turnos->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $val = Validator::make($request->all(), [
            'club_configuracion_id' => 'required',
            "cliente_id" => ['required', 'exists:clientes,id'],
            "cancha_id" => ['required', 'exists:canchas,id'],
            "fecha_Desde" => "required",
            "fecha_Hasta" => "required",
            "tipo_turno" => "required",
            "precio" => "required",
            "grupo" => "required",
        ]);

        if($val->fails()){
            return response()->json([
                    'msj' => 'Error', 
                    'razon' => 'Faltan datos por ingresar'
            ], 400);
        }else { 
            try {
                DB::beginTransaction();

                //verif turno normal
                $sqlDisponibilidadTurno= DB::table('turnos')
                                            ->where([
                                                ['club_configuracion_id', '=', $request->club_configuracion_id],
                                                ['cancha_id', '=', $request->cancha_id],
                                                ['fecha_Desde', '=', $request->fecha_Desde],
                                            ])
                                            ->get();

                if(count($sqlDisponibilidadTurno) > 1){
                    return response()->json([
                        'msj' => 'Error', 
                        'razon' => 'Esa fecha ya esta reservada'
                    ], 401);
                }
                                            

                $fechaDesde= substr($request->fecha_Desde, -20, -9); //$fechaDesde= "2018-12-25"
                $fechaHasta= substr($request->fecha_Hasta, -20, -9);
                
                $horaDesde= substr($request->fecha_Desde, -8, -1); //$horaDesde= "10:00:00"
                $horaHasta= substr($request->fecha_Hasta, -8, -1);
            
                $fechaDesdeInt = strtotime($fechaDesde); //Convierte el $fechaDesde a timestamp --> 1543104000
                $fechaHastaInt = strtotime($fechaHasta);

                //Distingo si la fechaDesde y la FechaHasta son iguales(turno normal). Si son distintas (Turno fijo). 
                if($fechaDesde == $fechaHasta){
                    // PARTE DE TURNO NORMAL
                    
                    $turno = Turno::create([
                        "club_configuracion_id" => $request->club_configuracion_id,
                        "cliente_id" => $request->cliente_id,
                        "cancha_id" => $request->cancha_id,
                        "fecha_Desde" => $request->fecha_Desde,
                        "fecha_Hasta" => $request->fecha_Hasta,
                        "tipo_turno" => $request->tipo_turno,
                        "precio" => $request->precio,
                        "grupo" => 1
                    ]);

                } else {
                    //PARTE DE TURNO FIJO
                    $cantDiasFijo= count($request->diasFijo);

                    $sqlGrupo= DB::table('club_configuracions')
                                    ->select('club_configuracions.ultimo_grupo')
                                    ->where('id', '=', $request->club_configuracion_id)
                                    ->get();

                    //Veo si el grupo tiene un turno fijo:
                    if($sqlGrupo[0]->ultimo_grupo > 1){
                        //Si tiene, incremento el turno fijo y actualizo el ultimo_grupo de la tabla club_configuracions
                        $grupoTurnoFijo= $sqlGrupo[0]->ultimo_grupo + 1;
                    } else {
                        //Si no tiene un turno fijo, asigno el numero 11 como inicial.
                        $grupoTurnoFijo= 11;
                    }

                    DB::table('club_configuracions')
                            ->where('id', '=', $request->club_configuracion_id)
                            ->update(['ultimo_grupo' => $grupoTurnoFijo]);
                    
                    //Recorro los dias seleccionados del turno fijo
                    for($j=0; $j < $cantDiasFijo; $j++){
                        //Por cada dia seleccionado, recorro todos los dias entre dos fechas
                        for ($i = $fechaDesdeInt; $i <= $fechaHastaInt; $i+= 86400){
                            //Si el dia actual es igual al dia seleccionado, creo un turno con su grupo y fecha correspondiente
                            if(date("D", $i) == $request->diasFijo[$j]){
                                //echo "". date("Y-m-d", $i). "<br>";
                                $turno = Turno::create([
                                    "club_configuracion_id" => $request->club_configuracion_id,
                                    "cliente_id" => $request->cliente_id,
                                    "cancha_id" => $request->cancha_id,
                                    "fecha_Desde" => date("Y-m-d", $i)." ". $horaDesde,
                                    "fecha_Hasta" => date("Y-m-d", $i)." ". $horaHasta,
                                    "tipo_turno" => $request->tipo_turno,
                                    "precio" => $request->precio,
                                    "grupo" => $grupoTurnoFijo
                                ]);      
                            }
                        }
                    }
                }

                DB::commit(); 
            }
            // Ha ocurrido un error, devolvemos la BD a su estado previo
            catch (\Exception $e)
            {
                dd($e);
                DB::rollback();
                return response()->json(["Mensaje" => "Error!!"]);
            }
        
            if($fechaDesde == $fechaHasta){
                return response()->json([
                    'msj' => 'Creacion de turno exitosa', 
                    'razon' => 'El turno NORMAL ha sido creado exitosamente'
                ], 201);
            } else {
                return response()->json([
                    'msj' => 'Creacion de turno exitosa', 
                    'razon' => 'El turno FIJO ha sido creado exitosamente'
                ], 201);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($club_id, $turno_id)
    {
        $turno = DB::table('turnos')
                    ->join('clientes', 'turnos.cliente_id', '=', 'clientes.id')
                    ->join('canchas', 'turnos.cancha_id', '=', 'canchas.id')
                        ->where('turnos.id', '=', $turno_id)    
                        ->where('turnos.club_configuracion_id', '=', $club_id)
                            ->select('turnos.id', 'turnos.grupo', 'turnos.cliente_id',
                                        'clientes.nombre', 'clientes.apellido',
                                        'turnos.cancha_id', 'canchas.deporte',
                                        'turnos.club_configuracion_id',
                                        'turnos.fecha_Desde', 'turnos.fecha_Hasta', 
                                        'turnos.tipo_turno', 'turnos.precio',)
                                ->get();
        
        return response()->json($turno, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($turno_id, Request $request, Turno $turno)
    {
        $sqlDisponibilidadTurno= DB::table('turnos')
                                    ->where([
                                        ['club_configuracion_id', '=', $request->club_configuracion_id],
                                        ['cancha_id', '=', $request->cancha_id],
                                        ['fecha_Desde', '=', $request->fecha_Desde],
                                        ['id', '<>', $turno_id],
                                    ])
                                    ->orWhere('fecha_Hasta', '=', $request->fecha_Hasta)
                                    ->get();

        if(count($sqlDisponibilidadTurno) > 1){
            return response()->json([
                'msj' => 'Error', 
                'razon' => 'No se puede editar porque esa fecha ya esta reservada'
            ], 401);
        }

        $turno = Turno::find($turno_id);

        $turno->update($request->all());
        return response()->json([
            'msj' => 'Exitosa', 
            'Mensaje' => 'Turno modificado'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($grupo, $turno_id=null, Turno $turno)
    {
        //Turno::destroy($turno_id);
        if(($grupo <= 1) && ($turno_id==null)){
            return response()->json([
                'msj' => 'Error',
                'razon' => 'Los turnos normales (grupo 1), no pueden ser eliminados '
            ]);
        }

        DB::table('turnos')
                ->where([
                    ['turnos.grupo', '=', $grupo],
                ])
                ->when($turno_id, function ($sql, $turno_id) {
                    return $sql->where('turnos.id', $turno_id);
                })
                ->delete();

        return response()->json([
            'msj' => 'Exitosa',
            'razon' => 'Turno eliminado'
        ]);
    }

}
