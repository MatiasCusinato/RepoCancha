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
    public function index($club_id, $cancha_id, $estado=null)
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
                                'turnos.estado')
                    ->when($estado, function ($sql, $estado) {
                        return $sql->where('turnos.estado', $estado);
                    })
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
            "estado" => "required",
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

                $fechaDesde= Carbon::parse($request->fecha_Desde)->format('Y-m-d'); //$fechaDesde= "2018-10-22"
                $fechaHasta= Carbon::parse($request->fecha_Hasta)->format('Y-m-d');
            
                $horaDesde= Carbon::parse($request->fecha_Desde)->format('H:i:s');//$horaDesde= "10:00:00"
                $horaHasta= Carbon::parse($request->fecha_Hasta)->format('H:i:s');
            
                
                $fechaDesdeInt = strtotime($request->fecha_Desde); //Convierte el $request->fecha_Desde a formato timestamp --> 1543104000
                $fechaHastaInt = strtotime($request->fecha_Hasta); 

                $fechaDeHoy = Carbon::createFromFormat('Y-m-d H:i:s', now(), 'UTC')
                            ->setTimezone('America/Buenos_Aires');
                $fechaDeHoy= Carbon::parse($fechaDeHoy)->format('Y-m-d 00:00:00');
                $fechaDeHoy = strtotime($fechaDeHoy); //Variable q contiene el dia de hoy en formato timestamp

                //Compruebo que la fechaDesde no sean anterior a la fecha de HOY, 
                //y tambien que la fechaDesde no sea posterior a la fechaHasta  y viceversa          
                if($request->estado =='Reservado' && $fechaDesdeInt < $fechaDeHoy){
                    return response()->json([
                        "msj" => 'Error',
                        "razon" => 'No podés RESERVAR un turno anterior a la fecha de HOY ('.Carbon::parse(now())->format('Y-m-d 00:00:00').'). Consejo: guardalo con otro estado.'
                    ], 400);
                    
                } else if ($fechaDesdeInt > $fechaHastaInt || $fechaHastaInt < $fechaDesdeInt){
                    return response()->json([
                        "msj" => 'Error',
                        "razon" => 'Las fechas estan mal especificadas (Fecha 1 es posterior a Fecha2 o viceversa)'
                    ], 400);
                }

                $respuestaTurnoOcupado= response()->json([
                    "msj" => "Error",
                    "razon" => "Esa fecha/horario ya esta reservado por otro turno, intente con otra fecha u horario."
                ], 400);


                //Distingo si la fechaDesde y la FechaHasta son iguales(turno normal). Si son distintas (Turno fijo). 
                if($fechaDesde == $fechaHasta || $request->grupo == 1){
                    // PARTE DE TURNO NORMAL

                    $valTurno = $this->validarTurno($request->fecha_Desde, $request->fecha_Hasta, 
                                            $request->club_configuracion_id, $request->cancha_id, $turno_id);
                
                    if(!$valTurno){
                        return $respuestaTurnoOcupado;
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

                    if(strtotime($horaHasta) <= strtotime($horaDesde)){
                        return response()->json([
                            "msj" => "Error",
                            "razon" => "La hora de finalizado no es correcta"
                        ]);
                    }

                    //cantidad de dias seleccionados a reservar, ejemplo: ["Lunes", "Miercoles", "Viernes"] = 3
                    $cantDiasFijo= count($request->diasFijo);

                    $contTurnosOmitidos= 0;
                    $contTurnosCreados= 0;

                    //sql que retorna el ultimo grupo de tal club
                    $sqlGrupo= DB::table('club_configuracions')
                                    ->select('club_configuracions.ultimo_grupo')
                                    ->where('id', '=', $request->club_configuracion_id)
                                    ->get();

                    //Veo si el grupo ya tiene un turno fijo asignado (grupo >= 11):
                    if($sqlGrupo[0]->ultimo_grupo >= 11){
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

            if($fechaDesde == $fechaHasta || $request->grupo == 1){
                return response()->json([
                    'msj' => 'Creacion de turno exitosa', 
                    'razon' => 'El turno NORMAL ha sido creado exitosamente'
                ], 201);
            } else {
                if($contTurnosCreados == 0 && $contTurnosOmitidos == 0){
                    return response()->json([
                        'msj' => 'Error', 
                        'razon' => 'Los dias especificados del turno FIJO no son acertados en cuanto al rango de fechas.'
                    ], 400);
                } else if($contTurnosCreados == 0){
                    return $respuestaTurnoOcupado;                 
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
    public function show($club_id, $cancha_id, $turno_id)
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
        }

        $fechaDesde= Carbon::parse($request->fecha_Desde)->format('Y-m-d'); //$fechaDesde= "2018-10-22"
        $fechaHasta= Carbon::parse($request->fecha_Hasta)->format('Y-m-d');
    
        $horaDesde= Carbon::parse($request->fecha_Desde)->format('H:i:s'); //$horaDesde= "10:00:00"
        $horaHasta= Carbon::parse($request->fecha_Hasta)->format('H:i:s');
            
        $fechaDesdeInt = strtotime($request->fecha_Desde); //Convierte el $request->fecha_Desde a formato timestamp --> 1543104000
        $fechaHastaInt = strtotime($request->fecha_Hasta); 
        //dd($fechaDesde,$fechaHasta,$horaDesde,$horaHasta,$fechaDesdeInt,$fechaHastaInt);

        $fechaDeHoy= Carbon::parse(now())->format('Y-m-d 00:00:00');
        $fechaDeHoy = strtotime($fechaDeHoy); //Variable q contiene el dia de hoy en formato timestamp
                
        //Compruebo que la fechaDesde no sean anterior a la fecha de HOY, 
        //y tambien que la fechaDesde no sea posterior a la fechaHasta  y viceversa     
        if($request->estado =='Reservado' && $fechaDesdeInt < $fechaDeHoy){
            return response()->json([
                "msj" => 'Error',
                "razon" => 'No podés RESERVAR un turno anterior a la fecha del dia Hoy ('.Carbon::parse(now())->format('Y-m-d 00:00:00').')'
            ], 400);
        } else if($fechaDesdeInt > $fechaHastaInt || $fechaHastaInt < $fechaDesdeInt){
            return response()->json([
                "msj" => 'Error',
                "razon" => 'Las fechas especificadas no son correctas (Fecha 1 es posterior a Fecha2 o viceversa)'
            ], 400);
        }

        $valTurno = $this->validarTurno($request->fecha_Desde, $request->fecha_Hasta, $request->club_configuracion_id, $request->cancha_id, $turno_id);

        if(!$valTurno){
            return response()->json([
                "msj" => "Error",
                "razon" => "No se pudo modificar ya que ese horario/fecha ya esta reservado"
            ], 400);
        }

        $turno = Turno::find($turno_id); //dd($turno);
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
        //dd($fechaComienzo, $fechaFin, $club, $cancha, intval($turno_id));

        //sql que retorna los turnos de un club, en una cancha, ENTRE DOS FECHAS, evitando un id de turno.
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
        
        //Si la sql esta vacia, retorno true o false
        if($sqlDisponibilidadTurno->isEmpty()){
            //No hay turnos a esa hora, retorno true, PUEDE reservar
            return true;
        } else {
            //Ya hay un turno reservado, retorno false, NO PUEDE reservar
            return false;
        }
    }


    public function ultimosReservados($club_id, Request $request)
    {
        $fechaComienzo= $request->fecha_Desde;
        $fechaFin= $request->fecha_Hasta;

        $ultimosTurnos= DB::table('turnos')
                                    ->join('clientes', 
                                                'turnos.cliente_id', '=', 'clientes.id')
                                    ->join('canchas', 
                                                'turnos.cancha_id', '=', 'canchas.id')
                                    ->where([
                                        ['turnos.club_configuracion_id', '=', $club_id],
                                        ['turnos.fecha_Desde', '<', $fechaFin], 
                                        ['turnos.fecha_Hasta', '>', $fechaComienzo],  
                                        ['turnos.estado', '=', 'Reservado'],  
                                    ])
                                    ->select('turnos.id', 'turnos.grupo', 'turnos.cliente_id',
                                                'clientes.nombre', 'clientes.apellido',
                                                'turnos.cancha_id', 'canchas.deporte',
                                                'turnos.club_configuracion_id',
                                                'turnos.tipo_turno', 'turnos.fecha_Desde',
                                                'turnos.fecha_Hasta', 'turnos.precio',
                                                'turnos.estado')
                                    ->get();
        //dd($ultimosTurnos);
        if($ultimosTurnos->isEmpty()){
            return response()->json([
                "msj" => "Error",
                "razon" => "No hay turnos entre las fechas indicadas. Pruebe con otras fechas"
            ]);
        } else {
            return response()->json([
                "msj" => "Ultimos turnos reservados",
                "data" => $ultimosTurnos
            ]);
        }
            

    }

}
