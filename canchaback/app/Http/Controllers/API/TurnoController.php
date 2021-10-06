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
        $fechaDesde= substr($request->fecha_Desde, -20, -9); //$fechaDesde= "2018-12-25"
        $fechaHasta= substr($request->fecha_Hasta, -20, -9);
    
        $fechaDesdeInt = strtotime($fechaDesde); //Convierte el $fechaDesde a timestamp --> 1543104000
        $fechaHastaInt = strtotime($fechaHasta);

        if($fechaDesde == $fechaHasta){
            echo "turno normal";
        } else {
            echo "turno fijo";
            echo "<br>";

            $cantDiasFijo= count($request->diasFijo);

            for ($i = $fechaDesdeInt; $i <= $fechaHastaInt; $i += 86400 *7){
                for($j=0; $j < $cantDiasFijo; $j++){
                    echo date("Y-m-d", strtotime($request->diasFijo[$j], $i))."  Dia: ".$request->diasFijo[$j].'<br>';
                }
            }

            //dd("stopppp");

        }

        /* $val = Validator::make($request->all(), [
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
                    'Respuesta' => 'Error', 
                    'Mensaje' => 'Faltan datos por ingresar'
            ], 400);
        }else { 
            try {
                DB::beginTransaction();

                $turno = Turno::create([
                    "club_configuracion_id" => $request->club_configuracion_id,
                    "cliente_id" => $request->cliente_id,
                    "cancha_id" => $request->cancha_id,
                    "fecha_Desde" => $request->fecha_Desde,
                    "fecha_Hasta" => $request->fecha_Hasta,
                    "tipo_turno" => $request->tipo_turno,
                    "precio" => $request->precio,
                    "grupo" => $request->grupo
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
        
            return response()->json($turno, 201);
        } */

        
        
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
    public function destroy($turno_id, Turno $turno)
    {
        Turno::destroy($turno_id);

        return response()->json([
            'msj' => 'Exitosa',
            'Mensaje' => 'Turno eliminado'
        ]);
    }
}
