<?php

namespace App\Http\Controllers;

use App\Abono;
use App\Cliente;
use App\Prestamo;
use Illuminate\Http\Request;

class AbonoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($id)
    {
        $prestamo = Prestamo::find($id);
        $clientes = Cliente::orderBy('created_at','desc')->paginate(5);
        return view('abonos.create', compact(['prestamo', 'clientes']));       
    }
    public function store(Request $request)
    {

        $cuota = new Abono;
        $cuota->prestamo_id= $request->input('prestamo_id');
        $cuota->cuota= $request->input('cuota');
        $cuota->fecha_abono= $request->input('fecha_abono');
        $cuota->notas= $request->input('notas');
        
        $cuota->save();
        $prestamo_id= $cuota->prestamo->id;

        return redirect('/prestamos/'.$prestamo_id)->with('success', 'Nuevo abono agregado');
    }
    public function edit($id, $idP)
    {
        $abono = Abono::find($id);
        $prestamo = Prestamo::find($idP);
        $clientes = Cliente::all();

        return view('abonos.edit', compact(['abono', 'prestamo', 'clientes']));

    }
    public function update(Request $request, $id)
    {
        $abono = Abono::find($id);
        $abono->cuota= $request->input('cuota');
        $abono->fecha_abono= $request->input('fecha_abono');
        $abono->notas= $request->input('notas');       
        $abono->save();
        $prestamo_id= $abono->prestamo->id;

        return redirect('/prestamos/'.$prestamo_id)->with('success', 'Abono actualizado');
    }
    public function destroy($id)
    {
      $abono = Abono::find($id);
      $abono->delete();
      $prestamo_id= $abono->prestamo->id;
      return redirect('/prestamos/'.$prestamo_id)->with('success', 'Abono eliminado');
    }    
}
