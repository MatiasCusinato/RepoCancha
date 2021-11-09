<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\clubConfiguracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class clubConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($paginado=null)
    {
        if($paginado==null){
            $club_configuracion = DB::table('club_configuracions')
                            ->select('club_configuracions.*')
                            ->orderBy('club_configuracions.id', 'asc')
                            ->get();

            if($club_configuracion->isEmpty()){
                return response()->json([
                    "msj" => "Error",
                    "razon" => "No hay clubes",
                ], 400);
            }   

            $paginado = count($club_configuracion);
        }
            $club_configuracion = DB::table('club_configuracions')
                                ->select('club_configuracions.*')
                                ->orderBy('id', 'asc')
                                ->paginate($paginado);

        return [
            'paginacion' => [
                'total'         => $club_configuracion->total(),
                'current_page'  => $club_configuracion->currentPage(),
                'per_page'      => $club_configuracion->perPage(),
                'last_page'     => $club_configuracion->lastPage(),
                'from'          => $club_configuracion->firstItem(),
                'to'            => $club_configuracion->lastPage(),
            ],

            'clubes' => $club_configuracion
        ];
        /* $club_configuracion = clubConfiguracion::all();
        return $club_configuracion->toJson(JSON_PRETTY_PRINT); */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $club_configuracion = clubConfiguracion::create($request->all());
        return response()->json($club_configuracion, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($club_id)
    {
        //$club_configuracion = clubConfiguracion::find($club_id);
        $club_configuracion = DB::table('club_configuracions')
                                    ->when($club_id, function ($sql, $club_id) {
                                        return $sql->where('id', '=', $club_id);
                                    })
                                    ->get();
        
        //dd($club_configuracion->isEmpty());
        
        if($club_id < 0 || $club_configuracion->isEmpty() || $club_configuracion == null){
            return response()->json([
                "msj" => "Error",
                "razon" => "El club especificado no existe"
            ], 400); 
        } else {
            return response()->json([
                "msj" => "Peticion exitosa",
                "club" => $club_configuracion,
            ], 200); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, clubConfiguracion $club_configuracion, $club_id)
    {
        $club_configuracion = clubConfiguracion::find($club_id);
        $club_configuracion->update($request->all());

        return response()->json([
            'Petición' => 'Modificacion exitosa',
            'Mensaje' => 'El club ha sido modificado'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($club_id, clubConfiguracion $club_configuracion)
    {
        /* clubConfiguracion::destroy($club_configuracion->id); */
        clubConfiguracion::destroy($club_id);
        return response()->json([
            'Petición' => 'Eliminacion exitosa', 
            'Mensaje' => 'El club ha sido eliminado'
        ]);
    }

    public function gananciaClub(Request $request){
        $fechaDesde= $request->fecha_Desde;
        $fechaHasta= $request->fecha_Hasta;
        $club= $request->club_configuracion_id;

        $fechaDesdeInt = strtotime($request->fecha_Desde); //Convierte el $request->fecha_Desde a formato timestamp --> 1543104000
        $fechaHastaInt = strtotime($request->fecha_Hasta);

        if($fechaDesdeInt > $fechaHastaInt || $fechaHastaInt < $fechaDesdeInt){
            return response()->json([
                "msj" => 'Error',
                "razon" => 'Puede que las fechas no sean correctas (Fecha 1 es posterior a Fecha2 o viceversa)'
            ], 400);
        } 
        
        $sqlTotalGanancia= DB::table('club_configuracions')
                            ->join('turnos', 'club_configuracions.id', '=', 'turnos.club_configuracion_id')
                            ->where([
                                ['club_configuracions.id', '=', $club],
                                ['turnos.estado', '=', 'Cobrado'],
                                ['turnos.fecha_Desde', '<=', $fechaHasta],
                                ['turnos.fecha_Hasta', '>=', $fechaDesde]
                            ])
                            ->select(DB::raw("COUNT(turnos.id) AS cant_turnos, 
                                            COALESCE( SUM(turnos.precio), 0) AS ganancia"))
                            ->get();
                            /* dd($TurnosGanancia); */
                    
        $TurnosGanancia= DB::table('turnos')
                            ->select("turnos.id","turnos.fecha_Desde","turnos.precio","turnos.cancha_id","turnos.tipo_turno")
                            ->join('club_configuracions', 'club_configuracions.id', '=', 'turnos.club_configuracion_id')
                            ->where([
                                ['turnos.club_configuracion_id', '=', $club],
                                ['turnos.estado', '=', 'Cobrado'],
                                ['turnos.fecha_Desde', '<=', $fechaHasta],
                                ['turnos.fecha_Hasta', '>=', $fechaDesde]
                            ])
                            ->get();
                            //dd($sqlGanancia[0]);

        return response()->json([
            "msj" => "Informe de ganancia exitoso",
            "TotalGanancia" => $sqlTotalGanancia[0],
            "data" => $TurnosGanancia
        ], 200);
    }
}
