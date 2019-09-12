@extends('layouts.app')
@section('content')

<div class="panel panel-default box-shadow" style="padding-bottom: 100px">      
    <div class="panel-body" style="border: none !important">
    <h2 align="center">Clientes</h2>

    <form action="{{route('clientes.index')}}" method="GET" class="form-group col-md-12">
        <div class="col-md-5" style="margin: 0 -12px">
            <input name="busqueda" value="{{$query}}" width="300px" class="form-control" placeholder="Búscar por nombre o zona..." />
        </div>
        <div class="col-md-1" style="margin: 0">
            <input name="cantidad" value="{{$cantidad}}" type="number" class="form-control">
        </div>
        <div class="col-md-2">
            <select name="orden" class="form-control" style="width: 120px">
                @if ($orden === 'Antiguos')
                    <option selected>Antiguos</option>
                    <option>Recientes</option>
                @else 
                    <option selected>Recientes</option>
                    <option>Antiguos</option>
                @endif          
            </select>
        </div>                
        <div class="col-md-2" style="margin: 0">
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span></button>
        </div>
    </form>

     <div class="table-responsive col-md-12 box-shadow">      
      <table class="table table-striped table-bordered">
       <thead>
        <tr>
            <th width="100px">Zona</th>
            <th width="">Nombre</th>
            <th width="100px">Monto</th>
            <th width="150px">Fecha de entrega</th>
            <th width="100px">Día de pago</th>
            <th width="100px">Opciones</th>
        </tr>
       </thead>
       <tbody>
            @foreach ($clientes as $cliente)
            <tr class="main">
                @if (App\Cliente::find($cliente->id)->prestamos()->where('cliente_id', $cliente->id)->exists()) 
                    <td>{{$cliente->zona}}</td>
                    <td>{{$cliente->nombres}}</td>
                    <td>{{App\Cliente::find($cliente->id)->prestamos()->where('cliente_id', $cliente->id)->first()->monto}}</td>
                    <td>{{ \Carbon\Carbon::parse(App\Cliente::find($cliente->id)->prestamos()->where('cliente_id', $cliente->id)->first()->fecha_entrega)->format('d/m /y')}}</td>
                    <td>{{App\Cliente::find($cliente->id)->prestamos()->where('cliente_id', $cliente->id)->first()->dia_pago}}</td>
                    <td><a href="/clientes/{{$cliente->id}}" class="fa fa-gear btn btn-primary" title="Ver/Editar"></a>                    
                        <span style="display:none">{{$prestamos = App\Prestamo::where('cliente_id', $cliente->id)->get()}}</span>
                        @if ($prestamos->count() === 1)
                            @foreach ($prestamos as $prestamo)
                                <a href="/cuotas/{{$prestamo->id}}/create" class="fa fa-usd btn btn-success" title="Agregar cuota al préstamo"></a>
                            @endforeach
                        @else 
                        @endif
                    </td>
                @else
                    <td>{{$cliente->zona}}</td>
                    <td>{{$cliente->nombres}}</td>
                    <td>Sin préstamos</td>
                    <td>Sin préstamos</td>
                    <td>Sin préstamos</td>
                    <td><a href="/clientes/{{$cliente->id}}" class="fa fa-gear btn btn-primary" title="Ver/Editar"></a> </td>
                @endif
            </tr>
            @endforeach  
       </tbody>

      </table>
      {{$clientes->links()}}
     </div>
    </div>    
   </div>

@endsection