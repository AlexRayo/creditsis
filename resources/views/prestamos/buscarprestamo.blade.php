@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Resultado de la búsqueda del préstamo</h2>
    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Id</th>
            <th scope="col">Cliente</th>
            <th scope="col">Monto solicitado</th>
            <th scope="col">Total a cancelar</th>
            <th scope="col">Saldo</th>
            <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>     

        @foreach($prestamoCliente as $pCliente)            
            <tr>                
                <td>{!! $pCliente->idCliente !!}</td>
                <td>{!! $pCliente->cliente->nombres !!}</td>
                <td>{!! $pCliente->monto !!}</td>
                <td>{!! $pCliente->total_cancelar !!}</td>
                <td>
                    @if ($pCliente->saldo === NULL)
                        {{$pCliente->total_cancelar}}
                    @else {{$pCliente->saldo}}
                    @endif
                </td>
                <td>
                    <a href="/prestamos/{{$pCliente->id}}" class="glyphicon glyphicon-pencil btn btn-primary" title="Ver/Editar"></a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="/cuotas/{{$pCliente->id}}/create" class="glyphicon glyphicon-usd btn btn-success" title="Agregar cuota"></a>
                </td> 
            </tr>
        @endforeach
    </tbody>
    </table>
</div>
@endsection