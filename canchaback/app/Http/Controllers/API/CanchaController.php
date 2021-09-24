<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cancha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CanchaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($club_id, Request $request)
    {

        //$cancha: consulta sql de los canchas pertenecientes a tal club

        $cancha = DB::table('canchas')
                            ->join('club_configuracions', 'canchas.club_configuracion_id', '=', 'club_configuracions.id')
                            ->where('canchas.club_configuracion_id', '=', $club_id)
                            ->select('canchas.*')
                            ->orderBy('id', 'asc')
                            ->paginate(4);

        return [
            'paginacion' => [
                'total'         => $cancha->total(),
                'current_page'  => $cancha->currentPage(),
                'per_page'      => $cancha->perPage(),
                'last_page'     => $cancha->lastPage(),
                'from'          => $cancha->firstItem(),
                'to'            => $cancha->lastPage(),
            ],

            'canchas' => $cancha
        ];

        //return $cancha->toJson(JSON_PRETTY_PRINT);
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
            'deporte' => 'required',
        ]); 

        if($val->fails()){
            return response()->json([
                    'Respuesta' => 'Error', 
                    'Mensaje' => 'Faltan datos por ingresar'
            ], 400);
        }else { 
            try {
                DB::beginTransaction();

                $cancha = Cancha::create([
                    "club_configuracion_id" => $request->club_configuracion_id,
                    "deporte" => $request->deporte,
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
        
            return response()->json($cancha, 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $cancha_id
     * @return \Illuminate\Http\Response
     */
    public function show($club_id, $cancha_id)
    {
        $cancha = DB::table('canchas')
                            ->join('club_configuracions', 'canchas.club_configuracion_id', '=', 'club_configuracions.id')
                            ->where('canchas.club_configuracion_id', '=', $club_id)
                            ->where('canchas.id', '=', $cancha_id)
                            ->select('canchas.*')
                            ->get();
                            
        return response()->json($cancha[0], 200); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cancha $cancha, $cancha_id)
    {
        $cancha = Cancha::find($cancha_id);
        $cancha->update($request->all());
        
        return response()->json([
            'Petición' => 'Exitosa',
            'Mensaje' => 'Cancha modificada'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cancha $cancha, $cancha_id)
    {
        Cancha::destroy($cancha_id);

        return response()->json([
            'Petición' => 'Exitosa',
            'Mensaje' => 'Cancha eliminada'
        ], 200);
    }

    public function filtroDeporte($club_id, $deporte){
        $cancha = DB::table('canchas')
                            ->join('club_configuracions', 'canchas.club_configuracion_id', '=', 'club_configuracions.id')
                            ->where([
                                ['canchas.club_configuracion_id', '=', $club_id],
                                ['canchas.deporte', 'like', '%' . $deporte . '%'],
                            ])
                            ->select('canchas.*')
                            ->get();

        return response()->json([
            'Petición' => 'Filtrado Exitoso',
            'canchas' => $cancha
        ], 200);
    }
}
?>
