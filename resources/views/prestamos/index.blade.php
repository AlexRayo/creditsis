@extends('layouts.app')
@section('content')
<div class="panel panel-default box-shadow" style="padding-bottom: 100px">      
    <div class="panel-body" style="border: none !important">
        <h2 align="center">Préstamos</h2>
        <form action="{{route('prestamos.index')}}" method="GET" class="form-group col-md-12">
            <div class="col-md-4">
                <input name="busqueda" value="{{$busqueda}}" width="300px" class="form-control" placeholder="Búscar por nombre o zona..." />
            </div>
            <div class="col-md-1">
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
                <tr>
                <th width="75px">Zona</th>
                <th width="">Cliente</th>
                <th width="100px">Monto</th>
                <th width="100px">Saldo</th>
                <th width="140px">Fecha de entrega</th>
                <th width="100px">Día de pago</th>
                <th width="75px">Detalle</th>
                </tr>
            </thead>
            <tbody>
            @if (count($prestamos)>0)                   
            @foreach ($prestamos as $prestamo)          
                <tr>
                    <td>{{$prestamo->cliente->zona}}</td>           
                    <td>{{$prestamo->cliente->nombres}}</td>
                    <td>{{$prestamo->monto}}</td>
                    <td>{{$prestamo->saldo}}</td>
                    <td>{{ \Carbon\Carbon::parse($prestamo->fecha_entrega)->format('d/m/Y')}}</td>
                    <td>{{$prestamo->dia_pago}}</td>
                    <td>
                        <a href="/prestamos/{{$prestamo->id}}" class="fa fa-gear btn btn-primary" title="Ver/Editar"></a>&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr> 
                
                @endforeach
                  
                @else
                    <h4>Aún no hay registros</h4> 
                @endif      
            </tbody>
        </table>
        {{$prestamos->render()}}
        </div>
    </div>
</div>
@endsection


