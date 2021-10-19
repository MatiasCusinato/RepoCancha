<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\clubConfiguracion;
use Illuminate\Http\Request;

class clubConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $club_configuracion = clubConfiguracion::all();
        return $club_configuracion->toJson(JSON_PRETTY_PRINT);
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
        $club_configuracion = clubConfiguracion::find($club_id);
        return $club_configuracion->toJson(JSON_PRETTY_PRINT);
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
}
