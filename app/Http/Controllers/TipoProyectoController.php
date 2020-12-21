<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoProyecto;

class TipoProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        return TipoProyecto::all();
        /*return TipoProyecto::where('user_id', auth()->id())->get();
        if($request->ajax()){
            return TipoProyecto::where('user_id', auth()->id())->get();
        }else{
            return view('home');
        }*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipo_proyecto = new TipoProyecto();
        $tipo_proyecto->nombre = $request->nombre;
        $tipo_proyecto->user_id = auth()->id();
        $tipo_proyecto->save();

        return $tipo_proyecto;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tipo_proyecto = TipoProyecto::find($id);
        $tipo_proyecto->nombre = $request->nombre;
        $tipo_proyecto->save();
        return $tipo_proyecto;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipo_proyecto = TipoProyecto::find($id);
        $tipo_proyecto->delete();
    }
}
