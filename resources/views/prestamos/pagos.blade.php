@extends('layouts.app')
@section('content')
<h2 class="" align="center">Pagos y pendientes<a href="#info" data-toggle="modal" class="btn fa fa-info-circle pull-right" style="font-size:35px"></a></h2>

<!-- FILTER ALL FORM-->
<div class="col-md-12">
    <form class="form-inline" action="{{route('prestamo.pagos')}}" method="GET">
        <div class="col-md-3">
            <label>Fecha inicio</label>
            <input type="date" name="minDate" class="form-control input-md" requiered value="{{$minDate}}"/>
        </div>        
        <div class="col-md-3">
            <label>Fecha cierre</label>
            <input type="date" name="maxDate" class="form-control input-md" requiered value="{{$maxDate}}"/>
        </div> 
        <div class="col-md-2">
            <label>Zona</label>
            <select name="zona" class="form-control" required>
                @if ($zona === 'AMBAS')
                    <option selected>AMBAS</option>
                    <option>NORTE</option>
                    <option>SUR</option>
                @elseif ($zona === 'NORTE')
                    <option selected>NORTE</option>
                    <option>SUR</option>
                    <option>AMBAS</option>
                @else 
                    <option selected>SUR</option>
                    <option>NORTE</option>
                    <option>AMBAS</option>
                @endif          
            </select>
        </div>
        <div class="col-md-2">
            <select name="cuentas" class="form-control" required>
                @if ($cuentas === 'Pendientes')
                    <option selected>Pendientes</option>
                    <option>Pagos</option>
                    <!--<option>Ambos</option>-->
                <!--elseif ($cuentas === 'Ambos')
                    <option selected>Ambos</option>
                    <option>Pagos</option>
                    <option>Pendientes</option>-->
                @else 
                    <option selected>Pagos</option>
                    <option>Pendientes</option>
                    <!--<option>Ambos</option>-->
                @endif          
            </select>
        </div>  
    <button type="submit" class="btn btn-primary">
        Búscar
        <span class="fa fa-search"></span>
    </button>
    {{ csrf_field()}}
    </form>
</div>

<!--***********************************-->

<span class="col-md-12 bg-gray" style="width: auto; text-align: left">
        @if ($cuentas != NULL && $diffInMonths > 0)
            {{'Resultado de '.$diffInMonths. ' meses / o '. $diffInDays. ' días'}}<br>
        @elseif ($cuentas != NULL && $diffInMonths === 0)
            {{'Resultado de '.$diffInDays. ' días'}}<br>
        @endif

        @if ($cuentas === 'Pendientes')
            Cuotas pendientes (Interés incluido): <b class="totalCuotas"></b><br>
            Capital por recuperar: <b class="totalAbonos"></b>
        @else
            Cuotas: <b class="totalCuotas"></b><br>
            Abonos: <b class="totalAbonos"></b>        
        @endif   
</span>
<div class="panel panel-default col-md-12 box-shadow" style="margin-bottom: 75px">
    <div class="panel-heading bg-blue">
    @if ($cuentas === "Pagos")
        <h3 align=""><b>Pagos</b> hechos de cuotas</h3>
    @else    
        <h3 align=""><b>Pendientes</b> de cuotas por cobrar</h3>
    @endif
    </div>
    <div class="panel-body">
        <div class="col-md-12 table-responsive">
            <table class="table table-hover table-bordered table-striped" id="tablaCuotas">
                <thead>
                    <tr>
                    <th>Cliente</th>
                    <th width="85px">% Interes</th>
                    <th width="140px">Capital solicitado</th>
                    @if ($cuentas === 'Pagos' || $cuentas === 'Pagos')
                        <th>Cuota</th>
                    @else
                        <th width="130px">Deuda en cuotas</th>
                    @endif                    
                    <th width="100px">Día de pago</th>
                    <th width="150px">Fecha de entrega</th>
                    <th width="50px">Zona</th>
                    </tr>
                </thead>
                <tbody>
                    

                @if ($cuentas === "Pagos")
                    @foreach($cuotasPagas as $cuota)
                        @if ($cuota->prestamo->cliente->zona === "$zona")                        
                            <tr>
                                <td>{{ $cuota->prestamo->cliente->nombres }}</td>
                                <td>{{ $cuota->prestamo->interes }} %</td>
                                <td>{{ $cuota->prestamo->monto }}</td>
                                <td>
                                    @if ($diffInMonths > 0)
                                        {{ $cuenta->valor_cuota * $diffInMonths}}
                                    @else
                                        {{ $cuenta->valor_cuota}}
                                    @endif
                                </td>
                                <td>{{$cuenta->dia_pago}}</td>
                                <td>{{ \Carbon\Carbon::parse($cuota->fecha_cuota)->day}}</td>
                                <td>{{$cuenta->cliente->zona}}</td>
                            </tr>
                        @elseif ($zona === "AMBAS")      
                            <tr>
                                <td>{{ $cuota->prestamo->cliente->nombres }}</td>
                                <td>{{ $cuota->prestamo->interes }}</td>
                                <td>{{ $cuota->prestamo->monto }}</td>
                                <td>
                                    @if ($diffInMonths > 0)
                                        {{ $cuota->valor_cuota * $diffInMonths}}
                                    @else
                                        {{ $cuota->valor_cuota}}
                                    @endif
                                </td>
                                <td>{{$cuota->dia_pago}}</td>
                                <td>{{ \Carbon\Carbon::parse($cuota->fecha_cuota)->day}}</td>
                                <td>{{$cuota->cliente->zona}}</td>
                            </tr>    

                        @endif
                    @endforeach
                    
                @elseif($cuentas === "Pendientes")
                    
                    @foreach ($pagosypendientes as $cuenta)                                                    
                        @if (App\Prestamo::find($cuenta->id)->cuotas()->where('prestamo_id', $cuenta->id)->exists())                                
                        @elseif ($cuenta->cliente->zona === "$zona")                        
                            <tr>
                                <td>{{ $cuenta->cliente->nombres }}</td>
                                <td>{{ (int) $cuenta->interes}} %</td>
                                <td>{{ $cuenta->monto }}</td>
                                <td>
                                    @if ($diffInMonths > 0)
                                        {{ $cuenta->valor_cuota * $diffInMonths}}
                                    @else
                                        {{ $cuenta->valor_cuota}}
                                    @endif
                                </td>
                                <td>{{$cuenta->dia_pago}}</td>
                                <td>{{ \Carbon\Carbon::parse($cuenta->fecha_entrega)->format('d/m/Y')}}</td>
                                <td>{{$cuenta->cliente->zona}}</td>
                            </tr>
                        @elseif ($zona === "AMBAS")      
                            <tr>
                                <td>{{ $cuenta->cliente->nombres }}</td>
                                <td>{{ (int) $cuenta->interes}} %</td>
                                <td>{{ $cuenta->monto }}</td>
                                <td>
                                    @if ($diffInMonths > 0)
                                        {{ $cuenta->valor_cuota * $diffInMonths}}
                                    @else
                                        {{ $cuenta->valor_cuota}}
                                    @endif
                                </td>
                                <td>{{$cuenta->dia_pago}}</td>
                                <td>{{ \Carbon\Carbon::parse($cuenta->fecha_entrega)->format('d/m/Y')}}</td>
                                <td>{{$cuenta->cliente->zona}}</td>
                            </tr>  
                        @endif                                          
                    @endforeach

                @else

                @foreach ($pagosypendientes as $cuenta)
                    <tr>
                        <td>{{ $cuenta->cliente->nombres }}</td>
                        <td>{{ (int) $cuenta->interes}} %</td>
                        <td>{{ $cuenta->monto }}</td>
                        <td>
                            @if ($diffInMonths > 0)
                                {{ $cuenta->valor_cuota * $diffInMonths}}
                            @else
                                {{ $cuenta->valor_cuota}}
                            @endif
                        </td>
                        <td>{{$cuenta->dia_pago}}</td>
                        <td>{{ \Carbon\Carbon::parse($cuenta->fecha_entrega)->format('d/m/Y')}}</td>
                        <td>{{$cuenta->cliente->zona}}</td>
                    </tr>                                         
                @endforeach

                @endif                       
                </tbody>
            </table>
            <span><p style="font-size: 20px">Total: <b class="totalCuotas text-orange"></b></p></span>
        </div>
    </div>    
</div>

<div class="panel panel-default col-md-12 box-shadow">
        <div class="panel-heading bg-blue">
            @if ($cuentas === 'Pagos')
                <h3 align="">Abonos al capital</h3></div>
            @else
                <h3 align="">Capital por recuperar</h3></div>
            @endif
            
        <div class="panel-body">
            <div class="col-md-12 table-responsive">
                <table class="table table-hover table-bordered table-striped" id="tablaAbonos">
                    <thead>
                        <tr>
                        <th>Cliente</th>
                        <th width="85px">% Interes</th>
                        <th width="140px">Capital solicitado</th>
                        @if ($cuentas === 'Pagos')
                            <th width="85px">Abono</th>
                        @else
                            <th width="85px">Saldo</th>
                        @endif
                        <th width="100px">Día de pago</th>
                        <th width="150px">Fecha de abono</th>
                        <th width="50px">Zona</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($cuentas === "Pagos")

                        @foreach($abonosPagos as $cuota)
                            @if ($cuota->prestamo->cliente->zona === "$zona")                        
                                <tr>
                                    <td>{{ $cuota->prestamo->cliente->nombres }}</td>
                                    <td>{{ (int) $cuota->prestamo->interes}} %</td>
                                    <td>{{ $cuota->prestamo->monto }}</td>
                                    <td>{{ $cuota->cuota }}</td>
                                    <td>{{ $cuota->prestamo->dia_pago}}</td>
                                    <td>{{$cuota->prestamo->cliente->zona}}</td>
                                </tr>
                            @elseif ($zona === "AMBAS")      
                                <tr>
                                    <td>{{ $cuota->prestamo->cliente->nombres }}</td>
                                    <td>{{ (int) $cuota->prestamo->interes}} %</td>
                                    <td>{{ $cuota->prestamo->monto }}</td>
                                    <td>{{ $cuota->cuota}}</td>
                                    <td>{{ $cuota->prestamo->dia_pago}}</td>
									<td>{{ $cuota->fecha_abono}}</td>
                                    <td>{{$cuota->prestamo->cliente->zona}}</td>
                                </tr>                    
                            @endif
                        @endforeach
                        
                        @elseif($cuentas === "Pendientes")
                    
                        @foreach ($pagosypendientes as $cuenta)                                                    
                            @if (App\Prestamo::find($cuenta->id)->abonos()->where('prestamo_id', $cuenta->id)->exists())                                
                            @elseif ($cuenta->cliente->zona === "$zona")                        
                                <tr>
                                    <td>{{ $cuenta->cliente->nombres }}</td>
                                    <td>{{ (int) $cuenta->interes}} %</td>
                                    <td>{{ $cuenta->monto }}</td>
                                    <td>{{ $cuenta->saldo}}</td>
                                    <td>{{$cuenta->dia_pago}}</td>
                                    <td>{{ \Carbon\Carbon::parse($cuenta->fecha_entrega)->format('d/m/Y')}}</td>
                                    <td>{{$cuenta->cliente->zona}}</td>
                                </tr>
                            @elseif ($zona === "AMBAS")      
                                <tr>
                                    <td>{{ $cuenta->cliente->nombres }}</td>
                                    <td>{{ (int) $cuenta->interes}} %</td>
                                    <td>{{ $cuenta->monto }}</td>
                                    <td>{{ $cuenta->monto}}</td>
                                    <td>{{$cuenta->dia_pago}}</td>
                                    <td>{{ \Carbon\Carbon::parse($cuenta->fecha_entrega)->format('d/m/Y')}}</td>
                                    <td>{{$cuenta->cliente->zona}}</td>
                                </tr>  
                            @endif                                          
                        @endforeach
    
                    @else
    
                    @foreach ($pagosypendientes as $cuenta)
                        <tr>
                            <td>{{ $cuenta->cliente->nombres }}</td>
                            <td>{{ (int) $cuenta->interes}} %</td>
                            <td>{{ $cuenta->monto }}</td>
                            <td>{{ $cuenta->valor_cuota }}</td>
                            <td>{{$cuenta->dia_pago}}</td>
                            <td>{{ \Carbon\Carbon::parse($cuenta->fecha_entrega)->format('d/m/Y')}}</td>
                            <td>{{$cuenta->cliente->zona}}</td>
                        </tr>                                         
                    @endforeach
    
                    @endif                       
                    </tbody>
                </table>
                <span><p style="font-size: 20px">Total: <b class="totalAbonos text-orange"></b></p></span>
            </div>
        </div>
    </div>


<div class="modal fade" id="info">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-primary"><b>¿Qué encuentro en esta página y cómo?</b></h4>
            </div>
            <div class="modal-body">            
            <p>Seleccioná un rango de fechas para mostrar las <b>CUOTAS</b> (Intereses mensuales)<br> 
                y <b>ABONOS</b> al capital que se han hecho a los <b>PRESTAMOS SOLICITADOS.</b><br>
                <br>
                Estos datos se deben filtrar por <b>zona</b>
                , las cuales pueden ser <b>NORTE</b>, <b>SUR</b> o <b>AMBAS</b> zonas. 
            </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>        
    var table = document.getElementById("tablaCuotas"), sumVal = 0;
    var table2 = document.getElementById("tablaAbonos"), sumVal2 = 0;
   
   for(var i = 1; i < table.rows.length; i++)
   {
       sumVal = sumVal + parseInt(table.rows[i].cells[3].innerHTML);
   }
   for(var i = 1; i < table2.rows.length; i++)
   {
       sumVal2 = sumVal2 + parseInt(table2.rows[i].cells[3].innerHTML);
   }

   var totalCuotas = document.getElementsByClassName("totalCuotas");
   var totalAbonos = document.getElementsByClassName("totalAbonos");

   for (var index = 0; index < totalCuotas.length; index++) {
        totalCuotas[index].innerHTML = " " + sumVal + " €";       
   }
   for (var i = 0; i < totalAbonos.length; i++) {
        totalAbonos[i].innerHTML = " " + sumVal2 + " €";       
   }

   

</script>
@endsection



