@extends('layouts.app')
@section('content')

<div class="col-lg-12 thumbnail">
    <a href="/prestamos/{{$prestamoCliente->id}}/edit" class="btn btn-primary pull-right fa fa-pencil"></a><!--Se le pasa el id del post actual con prestamoCliente id y Abre el archivo 'edit' -->
    <h2>Préstamo del cliente:&nbsp; <b> <a href="/clientes/{{$prestamoCliente->cliente->id}}">{{$prestamoCliente->cliente->nombres}} </a> </b></h2>
    <p>Monto solicitado: <b>{{$prestamoCliente->monto}}&nbsp;€</b></p>
    <p>Valor de la cuota: <b>@if ($prestamoCliente->saldo===NULL)
        {{$prestamoCliente->monto*($prestamoCliente->interes/100)}}&nbsp;€
        @else {{$prestamoCliente->valor_cuota}}&nbsp;€        
        @endif</b></p>
    <p>Tasa interés: <b>{{$prestamoCliente->interes}}&nbsp;%</b></p>
    <p>Saldo: <b> @if($prestamoCliente->saldo===NULL)
        {{$prestamoCliente->monto}}&nbsp;€ 
        @else {{$prestamoCliente->saldo}}&nbsp;€
        @endif</b></p>
    <p>Fecha de entrega: <b>{{ \Carbon\Carbon::parse($prestamoCliente->fecha_entrega)->format('d/m/Y')}}</b></p>
    <p>Día de pago: <b>{{$prestamoCliente->dia_pago}}</b> de cada mes</p>
    <p>Notas: <b> {{$prestamoCliente->notas}}</b></p>
    <br>        
</div>

<div class="col-lg-12 thumbnail">
    <h2>Cuotas efectuadas 
        @if ($prestamoCliente->saldo > 0)
        <a href="/cuotas/{{$prestamoCliente->id}}/create" class="btn btn-success fa fa-plus" title="Agregar cuota"></a>
        @else 
        <b class="text-primary">Préstamo cancelado</b>
        @endif            
    </h2>
    <table class="table table-striped">
    <thead>
        <tr>
        <th class="col-md-4" scope="col">Monto cuota</th>
        <th class="col-md-4" scope="col">Fecha de ingreso</th>
        <th class="col-md-4" scope="col">Editar</th>
        </tr>
    </thead>
        <tbody>                    
        @foreach($cuotas as $cuota)
            <tr>           
                <td>{{$cuota->cuota}}</td>
                <td>{{ \Carbon\Carbon::parse($cuota->fecha_cuota)->format('d/m/Y')}}</td>
                <td>
                    <a href="/cuotas/{{$cuota->id}}/edit/{{$cuota->prestamo->id}}" class="fa fa-pencil btn btn-primary" title="Editar la cuota"></a>&nbsp;&nbsp;&nbsp;&nbsp;
                </td>  
            </tr> 
        @endforeach           
        </tbody>
    </table>
</div>

    <div class="col-lg-12 thumbnail">
        <h2>Abonos al capital
            @if ($prestamoCliente->saldo > 0)
            <a href="/abonos/{{$prestamoCliente->id}}/create" class="btn btn-success fa fa-plus" title="Agregar cuota"></a>
            @else 
            <b class="text-primary">Préstamo cancelado</b>
            @endif 
        </h2>
    <table class="table table-striped">
        <thead>
            <tr>
            <th class="col-md-4" scope="col">Monto del abono</th>
            <th class="col-md-4" scope="col">Fecha de ingreso</th>
            <th class="col-md-4" scope="col">Editar</th>
            </tr>
        </thead>
        <tbody>       

        @foreach($abonos as $abono)
            <tr>           
                <td>{{$abono->cuota}}</td>
                <td>{{ \Carbon\Carbon::parse($abono->fecha_abono)->format('d/m/Y')}}</td>
                <td>
                    <a href="/abonos/{{$abono->id}}/edit/{{$abono->prestamo->id}}" class="fa fa-pencil btn btn-primary" title="Abono al capital"></a>&nbsp;&nbsp;&nbsp;&nbsp;
                </td>  
            </tr>   
        @endforeach
    </tbody>
    </table>
    </div>
@endsection