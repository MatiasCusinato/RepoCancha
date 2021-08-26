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
    public function show($id)
    {
        $club_configuracion = clubConfiguracion::find($id);
        return $club_configuracion->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, clubConfiguracion $club_configuracion)
    {
        $club_configuracion->update($request->all());
        return response()->json(['Petición' => 'Exitosa', 'Mensaje' => 'Club modificado']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(clubConfiguracion $club_configuracion)
    {
        clubConfiguracion::destroy($club_configuracion->id);
        return response()->json(['Petición' => 'Exitosa', 'Mensaje' => 'Club eliminado']);
    }
}
