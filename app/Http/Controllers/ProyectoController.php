<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyecto;
use App\User;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->rol_id == 1) {
            //return Proyecto::all();
            $proyecto = Proyecto::paginate(5);
            return [
                'pagination' => [
                    'total'        => $proyecto->total(),
                    'current_page' => $proyecto->currentPage(),
                    'per_page'     => $proyecto->perPage(),
                    'last_page'    => $proyecto->lastPage(),
                    'from'         => $proyecto->firstItem(),
                    'to'           => $proyecto->lastItem(),
                ],
                'proyecto' => $proyecto
            ];
        }else{
            return Proyecto::where('user_id', auth()->id())->get();
            if($request->ajax()){
                return Proyecto::where('user_id', auth()->id());
            }else{
                return view('home');
            }
        }
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
        $proyecto = new Proyecto();
        $proyecto->nombre = $request->nombre;
        $proyecto->tipo = $request->tipo;
        $proyecto->servicio = $request->servicio;
        $proyecto->descripcion = $request->descripcion;
        $proyecto->estatus = $request->estatus;
        $proyecto->correo = $request->correo;
        $proyecto->telefono = $request->telefono;
        $proyecto->user_id = auth()->id();
        $proyecto->save();

        return $proyecto;
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
        $proyecto = Proyecto::find($id);
        $proyecto->nombre = $request->nombre;
        $proyecto->tipo = $request->tipo;
        $proyecto->servicio = $request->servicio;
        $proyecto->descripcion = $request->descripcion;
        $proyecto->estatus = $request->estatus;
        $proyecto->correo = $request->correo;
        $proyecto->telefono = $request->telefono;
        $proyecto->save();
        return $proyecto;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proyecto = Proyecto::find($id);
        $proyecto->delete();
    }
}
