<?php

namespace App\Http\Controllers;

use App\Cuota;
use App\Cliente;
use App\Prestamo;
use Illuminate\Http\Request;

class CuotaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cuotas.index'); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $prestamo = Prestamo::find($id);
        $clientes = Cliente::orderBy('created_at','desc')->paginate(5);
        return view('cuotas.create', compact(['prestamo', 'clientes']));       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $cuota = new Cuota;
        $cuota->prestamo_id= $request->input('prestamo_id');
        $cuota->cuota= $request->input('cuota');
        $cuota->fecha_cuota= $request->input('fecha_cuota');
        $cuota->fecha_prox_cuota= $request->input('fecha_prox_cuota');
        $cuota->notas= 0;
        
        $prestamo_id= $request->input('prestamo_id');
        $cuota->save();

        return redirect('/prestamos/'.$prestamo_id)->with('success', 'Nueva cuota agregada');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cuota = Cuota::find($id);
        $showCliente = Cliente::all();
        return view('cuotas.show', compact(['cuota','showCliente']));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $idP)
    {
        $cuota = Cuota::find($id);
        $prestamo = Prestamo::find($idP);
        $clientes = Cliente::all();        

        return view('cuotas.edit', compact(['cuota', 'prestamo', 'clientes']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cuota = Cuota::find($id);
        $cuota->cuota= $request->input('cuota');
        $cuota->fecha_cuota= $request->input('fecha_cuota'); 

        $prestamo_id = $cuota->prestamo->id;
        $cuota->save();

        return redirect('/prestamos/'.$prestamo_id)->with('success', 'Cuota actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $cuota = Cuota::find($id);
      $cuota->delete();
      $prestamo_id = $cuota->prestamo->id;
        return redirect('/prestamos/'.$prestamo_id)->with('success', 'Cuota eliminada');
    }
}
