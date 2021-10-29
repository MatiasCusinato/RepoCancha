<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Turno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


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
                                        'turnos.fecha_Hasta', 'turnos.precio',
                                        'turnos.estado',)
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
        ///$turno_id=0;

        
        
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
                $turno_id=0;

                $fechaDesde= substr($request->fecha_Desde, -20, -9); //$fechaDesde= "2018-12-25"
                $fechaHasta= substr($request->fecha_Hasta, -20, -9);
                
                $horaDesde= substr($request->fecha_Desde, -8); //$horaDesde= "10:00:00"
                $horaHasta= substr($request->fecha_Hasta, -8);
            
                $fechaDesdeInt = strtotime($fechaDesde); //Convierte el $fechaDesde a timestamp --> 1543104000
                $fechaHastaInt = strtotime($fechaHasta);

                /* $fechaDeHoy = Carbon::createFromFormat('Y-m-d', now()); */
                $fechaDeHoy= Carbon::parse(now())->format('Y-m-d 00:00:00');
                $fechaDeHoy = strtotime($fechaDeHoy);           
                //comparo fechas (si la fechaDesde es anterior a Hoy 
                //                     O si la fechaDesde es posterior a la FechaHasta)                
                if(($fechaDesdeInt < $fechaDeHoy  && $request->estado =='Reservado') || $fechaDesdeInt > $fechaHastaInt){
                    return response()->json([
                        "msj" => 'Error',
                        "razon" => 'Puede que la fecha especificada sea vieja, o que las fechas no son correctas (Fecha 1 es posterior a Fecha2)'
                    ], 400);
                } 


                //Distingo si la fechaDesde y la FechaHasta son iguales(turno normal). Si son distintas (Turno fijo). 
                if($fechaDesde == $fechaHasta){
                    // PARTE DE TURNO NORMAL

                    $valTurno = $this->validarTurno($request->fecha_Desde, $request->fecha_Hasta, 
                                            $request->club_configuracion_id, $request->cancha_id, $turno_id);
                
                    if(!$valTurno){
                        return response()->json([
                            "msj" => "Error",
                            "razon" => "No se pudo realizar el turno debido a que ya esta reservado por otro turno en la misma hora o fecha"
                        ],400);
                    }
                    
                    $turno = Turno::create([
                        "club_configuracion_id" => $request->club_configuracion_id,
                        "cliente_id" => $request->cliente_id,
                        "cancha_id" => $request->cancha_id,
                        "fecha_Desde" => $request->fecha_Desde,
                        "fecha_Hasta" => $request->fecha_Hasta,
                        "tipo_turno" => $request->tipo_turno,
                        "precio" => $request->precio,
                        "grupo" => 1,
                        "estado" => $request->estado
                    ]);

                } else {
                    //PARTE DE TURNO FIJO
                    $cantDiasFijo= count($request->diasFijo);

                    $contTurnosOmitidos= 0;
                    $contTurnosCreados= 0;

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

                    //actualizo el ultimo turno fijo del club correspondiente
                    DB::table('club_configuracions')
                            ->where('id', '=', $request->club_configuracion_id)
                            ->update(['ultimo_grupo' => $grupoTurnoFijo]);
                    
                    //Recorro los dias seleccionados del turno fijo
                    for($j=0; $j < $cantDiasFijo; $j++){
                        //Por cada dia seleccionado, recorro todos los dias entre dos fechas
                        for ($i = $fechaDesdeInt; $i <= $fechaHastaInt; $i+= 86400){
                            //Si el dia actual es igual al dia seleccionado, creo un turno con su grupo y fecha correspondiente
                            if(date("D", $i) == $request->diasFijo[$j]){
                                $diaDesdeIndex= "". date("Y-m-d", $i)." ".$horaDesde;
                                $diaHastaIndex= "". date("Y-m-d", $i)." ".$horaHasta;
                                $valTurno = $this->validarTurno($diaDesdeIndex, $diaHastaIndex, 
                                            $request->club_configuracion_id, $request->cancha_id, $turno_id);
                
                                if(!$valTurno){
                                    $contTurnosOmitidos++; 
                                    continue;
                                } else {
                                    $contTurnosCreados++; 

                                    $turno = Turno::create([
                                        "club_configuracion_id" => $request->club_configuracion_id,
                                        "cliente_id" => $request->cliente_id,
                                        "cancha_id" => $request->cancha_id,
                                        "fecha_Desde" => date("Y-m-d", $i)." ". $horaDesde,
                                        "fecha_Hasta" => date("Y-m-d", $i)." ". $horaHasta,
                                        "tipo_turno" => $request->tipo_turno,
                                        "precio" => $request->precio,
                                        "grupo" => $grupoTurnoFijo,
                                        "estado" => $request->estado
                                    ]);      
                                }

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
                return response()->json(["Mensaje" => "Error (ROLLBACK DE LA BD)!!"]);
            }
        
            if($fechaDesde == $fechaHasta){
                return response()->json([
                    'msj' => 'Creacion de turno exitosa', 
                    'razon' => 'El turno NORMAL ha sido creado exitosamente'
                ], 201);
            } else {
                if($contTurnosCreados == 0){
                    return response()->json([
                        'msj' => 'Error', 
                        'razon' => 'No se pudieron crear los turnos debido a que ese horario ya se encuentra ocupado\reservado'
                    ], 400);                 
                } else {
                    return response()->json([
                        'msj' => 'Creacion de turno exitosa', 
                        'razon' => 'El turno FIJO ha sido creado exitosamente (turnos creados: '.$contTurnosCreados.'; turnos NO creados: '.$contTurnosOmitidos.')'
                    ], 201);
                }
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
                                        'turnos.tipo_turno', 'turnos.precio',
                                        'turnos.estado',)
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
        //validarTurno()...
        $valTurno = $this->validarTurno($request->fecha_Desde, $request->fecha_Hasta, $request->club_configuracion_id, $request->cancha_id, $turno_id);
        
        if(!$valTurno){
            return response()->json([
                "msj" => "Error",
                "razon" => "No se pudo modificar ya que ese horario/fecha ya esta reservado"
            ], 400);
        }

        $turno = Turno::find($turno_id);
        //dd($turno);
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
            ], 400);
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
        ], 200);
    }

    //Funcion que valida si las fechas del turno a crear o editar, estan ocupadas o no
    public function validarTurno($fechaComienzo, $fechaFin, $club, $cancha, $turno_id=0)
    {
        $fechaDesde= substr($fechaComienzo, -20, -9); //$fechaDesde= "2018-12-25"
        $fechaHasta= substr($fechaFin, -20, -9);
        //dd($anioDesde, $mesDesde, $diaDesde);
        
        $horaDesde= substr($fechaComienzo, -8); //$horaDesde= "10:00:00"
        $horaHasta= substr($fechaFin, -8);
    
        //dd($fechaComienzo, $fechaFin, $club, $cancha, intval($turno_id));

        $sqlDisponibilidadTurno= DB::table('turnos')
                                    ->where([
                                        ['turnos.club_configuracion_id', '=', $club],
                                        ['turnos.cancha_id', '=', $cancha],
                                        ['turnos.fecha_Desde', '<', $fechaFin], 
                                        ['turnos.fecha_Hasta', '>', $fechaComienzo],  
                                        ['turnos.id', '!=', $turno_id],  
                                    ])
                                    ->get();
        //dd($sqlDisponibilidadTurno);    


        if($sqlDisponibilidadTurno->isEmpty()){
            //No hay turnos a esa hora, retorno true, PUEDE reservar
            return true;
        } else {
            //Ya hay un turno reservado, retorno false, NO PUEDE reservar
            return false;
        }
    }

}
