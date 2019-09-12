<?php
namespace App\Http\Controllers;

use App\Cliente;
use App\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
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
    public function index(Request $request)
    {
        $prestamos = Prestamo::all();
        $query = $request->get('busqueda'); 
        $cantidad = $request->get('cantidad');
        $orden = $request->get('orden');

        if ($cantidad === NULL) {
            $cantidad = 10;
        }
        if ($orden === 'Recientes') {
            $clientes = Cliente::orderBy('updated_at','desc')
            ->where('nombres', 'like', '%'.$query.'%')
            ->orWhere('zona', 'like', '%'.$query.'%')
            ->paginate($cantidad);
        }
        elseif ($orden === 'Antiguos')
            $clientes = Cliente::orderBy('updated_at','asc')
            ->where('nombres', 'like', '%'.$query.'%')
            ->orWhere('zona', 'like', '%'.$query.'%')
            ->paginate($cantidad);
        else
            $clientes = Cliente::orderBy('updated_at','desc')
            ->where('nombres', 'like', '%'.$query.'%')
            ->orWhere('zona', 'like', '%'.$query.'%')
            ->paginate($cantidad); 
        
          
        
        return view('clientes.index', compact(['orden','query','clientes','prestamos','cantidad']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cliente = new Cliente;        
        $cliente->nombres= $request->input('nombres');
        $cliente->zona= $request->input('zona');
        $cliente->direccion= $request->input('direccion');
        $cliente->sexo= 0;
        $cliente->edad= 0;
        $cliente->telefono= $request->input('telefono');
        $cliente->profesion= 0;
        $cliente->notas= 'Ninguna';
        $cliente->save();
        $nombreCliente = $request->input('nombres');

        return redirect('/clientes')->with('success', 'Agregado '. $nombreCliente .' como nuevo cliente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $showCliente = Cliente::find($id);
        $prestamos = Prestamo::where('cliente_id', $id)->get();

        return view('clientes.show', compact(['showCliente', 'prestamos']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $cliente = Cliente::find($id);
        return view('clientes.edit')->with('showCliente', $cliente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
 
        $cliente = Cliente::find($id);
        $cliente->zona= $request->input('zona');
        $cliente->nombres= $request->input('nombres');
        $cliente->sexo= 0;
        $cliente->edad= 0;
        $cliente->direccion= $request->input('direccion');
        $cliente->telefono= $request->input('telefono');
        $cliente->profesion= 0;
        $cliente->notas= 'Ninguna';
        $cliente->save();
        $nombreCliente = $request->input('nombres');
        $cliente_id = $cliente->id;
        return redirect('/clientes/'.$cliente_id)->with('success', 'Datos del cliente actualizados');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        $cliente->delete();
        return redirect('/clientes')->with('success', 'Cliente eliminado');
    }
    
}




