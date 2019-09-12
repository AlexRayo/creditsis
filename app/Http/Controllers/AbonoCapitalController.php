<?php

namespace App\Http\Controllers;

use App\Abono;
use App\Cliente;
use App\Prestamo;
use Illuminate\Http\Request;

class AbonoCapitalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($id)
    {
        $prestamo = Prestamo::find($id);
        $clientes = Cliente::orderBy('created_at','desc')->paginate(5);
        return view('abonocapital.create', compact(['prestamo', 'clientes']));       
    }
    public function store(Request $request)
    {

        $cuota = new Abono;
        $cuota->idPrestamo= $request->input('idPrestamo');
        $cuota->cuota= $request->input('cuota');
        $cuota->fechaAbono= $request->input('fechaAbono');
        $cuota->observaciones= 0;
        
        $cuota->save();
        $idPrestamo= $cuota->prestamo->id;

        return redirect('/prestamos/'.$idPrestamo)->with('success', 'Nuevo abono agregado');
    }
    public function edit($id, $idP)
    {
        $abono = Abono::find($id);
        $prestamo = Prestamo::find($idP);
        $clientes = Cliente::all();

        return view('abonocapital.edit', compact(['abono', 'prestamo', 'clientes']));

    }
    public function update(Request $request, $id)
    {
        $abono = Abono::find($id);
        $abono->cuota= $request->input('cuota');
        $abono->fechaAbono= $request->input('fechaAbono');       
        $abono->save();
        $idPrestamo= $abono->prestamo->id;

        return redirect('/prestamos/'.$idPrestamo)->with('success', 'Abono actualizado');
    }
    public function destroy($id)
    {
      $abono = Abono::find($id);
      $abono->delete();
      $idPrestamo= $abono->prestamo->id;
      return redirect('/prestamos/'.$idPrestamo)->with('success', 'Abono eliminado');
    }    
}
