<?php
namespace App\Http\Controllers;
use App\Prestamo;
use App\Cliente;
use App\Cuota;
use App\Abono;
use App\User;
use Illuminate\Http\Request;
use Carbon;
use DB;

class PrestamoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');    
    }

    public function index(Request $request)
    {
        $busqueda = $request->get('busqueda');
        $cantidad = $request->get('cantidad');
        $orden = $request->get('orden');
        if ($cantidad === NULL) {
            $cantidad = 10;
        }
        if ($orden === 'Recientes') {
            $prestamos = Prestamo::orderBy('updated_at','desc')
            ->join('clientes', 'clientes.id','=','prestamos.cliente_id')
           ->select('prestamos.*','clientes.nombres')
           ->where('clientes.nombres', 'like', '%'.$busqueda.'%')
           ->orWhere('clientes.zona', 'like', '%'.$busqueda.'%')
           ->paginate($cantidad);
        }
        else
        $prestamos = Prestamo::orderBy('updated_at','asc')
        ->join('clientes', 'clientes.id','=','prestamos.cliente_id')
       ->select('prestamos.*','clientes.nombres')
       ->where('clientes.nombres', 'like', '%'.$busqueda.'%')
       ->orWhere('clientes.zona', 'like', '%'.$busqueda.'%')
       ->paginate($cantidad);



    	return view('prestamos.index', compact('prestamos','busqueda','cantidad','orden'));
       
    }

    public function create($id)
    {
        $cliente = Cliente::find($id);
        return view('prestamos.create', compact(['cliente']));
    } 

    public function store(Request $request)
    {
        //Se crean nuevos datos de la misma forma como tinker
        $prestamo = new Prestamo;
        $prestamo->cliente_id= $request->get('cliente_id');
        $prestamo->monto= $request->input('monto');        
        $prestamo->interes= $request-> input('interes');
        $prestamo->valor_cuota= $request->input('valor_cuota');
        $prestamo->saldo= $request->input('monto');
        $prestamo->fecha_entrega= $request->input('fecha_entrega');
        $prestamo->utilidad= 0 ;
        $prestamo->dia_pago= $request->input('dia_pago');
        $prestamo->notas= $request->input('notas');
        $prestamo->save();
        $cliente_id = $request->get('cliente_id');     
         
        return redirect('/clientes/'.$cliente_id)->with('success', 'Nuevo prestamo agregado');
    }

    public function show($id)    {
        $prestamoCliente = Prestamo::find($id);
        $abonos = Abono::where('prestamo_id', $id)->get();        
        $cuotas = cuota::where('prestamo_id', $id)->get();

        return view('prestamos.show', compact(['prestamoCliente', 'abonos', 'cuotas']));
    }

    public function edit($id)
    {
        $prestamos = Prestamo::find($id);
        $clientes = Cliente::all();
        return view('prestamos.edit', compact(['clientes','prestamos']));
    }

    public function update(Request $request, $id)
    {

        $prestamo = Prestamo::find($id);
        $prestamo->cliente_id= $request->input('cliente_id');
        $prestamo->monto= $request->input('monto');        
        $prestamo->interes= $request-> input('interes');
        $prestamo->valor_cuota= $request->input('valor_cuota');
        $prestamo->saldo= $request->input('nuevoSaldo');
        $prestamo->fecha_entrega= $request->input('fecha_entrega');
        $prestamo->dia_pago= $request->input('dia_pago');
        $prestamo->notas= $request->input('notas');
        $prestamo->save();

        return redirect('/prestamos/'.$id)->with('success', 'Prestamo actualizado');
    }

    public function destroy($id)
    {
        $prestamo = Prestamo::find($id);
        $prestamo->delete();
        $cliente_id= $prestamo->cliente->id;
        return redirect('/clientes/'.$cliente_id)->with('success', 'Prestamo eliminado');
    }
    public function utilidades(Request $request)
    {
       
       $prestamos = Prestamo::all();
       $zona = $request->get('zona');

       return view('prestamos.utilidades', compact(['prestamos','zona']));
       
    }
    public function pagos(Request $request)
    {   
        $minDate = $request->get('minDate');
        $maxDate = $request->get('maxDate');


        /* Determina la diferencias en meses*/
        if ($minDate != '' || $maxDate != '') {
            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', "$minDate".' 23:59:59');
            $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', "$maxDate".' 23:59:59');        
            $diffInMonths = $to->diffInMonths($from);
            $diffInDays = $to->diffInDays($from);
        } else {
            $diffInMonths = '00/00/0000';
            $diffInDays = '00/00/0000';
            $minDate = '00/00/0000';
            $maxDate = '00/00/0000';
        }


        /*******/

        $zona = $request->get('zona');#solo para recibir y regresar el request
        $cuentas = $request->get('cuentas');#solo para recibir y regresar el request
        $minDatePD = Carbon\Carbon::parse($minDate)->day;
        $maxDatePD = Carbon\Carbon::parse($maxDate)->day;
        $maxDateDaysInMonth = Carbon\Carbon::parse($maxDate)->daysInMonth;#Determina la cantidad de días q tiene el mes de cierre
        $maxDateMonth = Carbon\Carbon::parse($maxDate)->month;

        $pagosypendientes = Prestamo::select("prestamos.*")
        ->whereBetween('dia_pago', ["$minDatePD", "$maxDatePD"])#Es necesario agregarle la hora del final del día de la última fecha, puesto que la db contiene hora ("datetime" y no solo "date"); la fecha de inicio no lo requiere porq por defecto toma 00:00:00
        ->get();
    
        $cuotasPagas = Cuota::select("cuotas.*")
        ->whereBetween('fecha_cuota', ["$minDate", "$maxDate".' 23:59:59'])#Es necesario agregarle la hora del final del día de la última fecha, puesto que la db contiene hora ("datetime" y no solo "date"); la fecha de inicio no lo requiere porq por defecto toma 00:00:00
        ->get();
        
        $abonosPagos = Abono::select("abonos.*")
        ->whereBetween('fecha_abono', ["$minDate", "$maxDate".' 23:59:59'])
        ->get(); 
    
        return view('prestamos.pagos', compact(
            'diffInDays',
            'diffInMonths',
            'pagosypendientes',
            'minDate',
            'maxDate',
            'maxDatePD',
            'zona',
            'cuentas',
            'cuotasPagas',
            'abonosPagos', 
            'maxDateDaysInMonth',
            'maxDateMonth'
        ));     
    }  
}
