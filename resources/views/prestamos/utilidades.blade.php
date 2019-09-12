@extends('layouts.app')
@section('content')
<div class="col-md-12" style="padding-bottom: 100px">
    <h2 align="center">Inversión y utilidades<a href="#info" data-toggle="modal" class="btn fa fa-info-circle pull-right" style="font-size:35px"></a></h2>
    <div class="col-md-12" style="margin-bottom: 25px">
        <form class="form-inline" action="{{route('prestamo.utilidades')}}" method="GET">
            <div class="col-md-3" style="margin: 0">
                <b>Mostrar por zona:&nbsp;</b>
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

            <div class="col-md-1"> 
                <button type="submit" class="btn btn-primary">
                    <span class="fa fa-search"></span>
                </button>
            </div>
        </form>
    </div>
    
<div class="panel panel-default col-md-12 box-shadow">
    <div class="panel-heading"><h3 align="">Descripción de préstamos</h3></div>
    <div class="panel-body">    
        <div class="col-md-12 table-responsive">
            <table class="table table-hover table-bordered table-striped" id="tabla">
                <thead>
                    <tr>
                        <th>Nombre del cliente</th>                    
                        <th>Fecha de registro</th>
                        <th>Capital solicitado</th>
                        <th>Saldo de capital</th>
                        <th>Utilidad del préstamo</th>                         
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prestamos as $prestamo)
                        @if ($prestamo->cliente->zona === "$zona")
                            <tr>
                                <td>{{$prestamo->cliente ->nombres}}</td>
                                <td>{{ \Carbon\Carbon::parse($prestamo->fecha_entrega)->format('d/m/Y')}}</td>
                                <td>{{$prestamo->monto}}</td>
                                <td>
                                    @if ($prestamo->saldo==='NULL')
                                        {{$prestamo->capital}}
                                    @else {{$prestamo->saldo}}
                                    @endif
                                </td>
                                <td>@if ($prestamo->utilidad ===NULL)
                                    0.00
                                @else {{$prestamo->utilidad}}
                                @endif</td>
                                 
                            </tr>
                        @elseif ($zona === "AMBAS")
                            <tr>
                                <td>{{$prestamo->cliente->nombres}}</td>
                                <td>{{ \Carbon\Carbon::parse($prestamo->fecha_entrega)->format('d/m/Y')}}</td>
                                <td>{{$prestamo->monto}}</td>
                                <td>
                                    @if ($prestamo->saldo===NULL)
                                        {{$prestamo->monto}}
                                    @else {{$prestamo->saldo}}
                                    @endif
                                </td>
                                <td>@if ($prestamo->utilidad ===NULL)
                                    0.00
                                @else {{$prestamo->utilidad}}
                                @endif</td> 
                            </tr>     
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="panel panel-default col-md-12 box-shadow">       
    <div class="panel-heading"><h3 class="font-weight-bold text-primary"><b>Totales</b></h3></div>
    <div class="panel-body">    
        <div class="col-md-12 table-responsive">
            <table class="table table-hover table-bordered table-striped" id="tabla">
            <thead>
                <tr>
                    <th class="text-primary">Cantidad de préstamos</th>
                    <th class="text-primary">Capital invertido</th>
                    <th class="text-primary">Capital por recuperar</th>                
                    <th class="text-primary">Total de utilidades</th>                         
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="cantPrestamos" style="font-size: bold"></td>
                    <td id="capitalClientes" style="font-size: bold"></td>
                    <td id="deudaClientes" style="font-size: bold"></td>
                    <td id="utilidades" style="font-size: bold"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>    
</div>
</div>


<div class="modal fade" id="info">
        <div class="modal-dialog">
           <div class="modal-content">
              <div class="modal-header">
                 <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">¿Qué encuentro en esta página?</h4>
              </div>
              <div class="modal-body">            
                <p>Esta página muestra lo que se ha <b>invertido</b>, el <b>Capital por recuperar</b> y el <b>total de utilidades</b> obtenidas, estos datos se deben filtrar por <b>zona</b>
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
        var tableCapital = document.getElementById("tabla"), capital = 0;/*Debe inicializarse en cero*/
        var tableDeuda = document.getElementById("tabla"), deuda = 0;
        var tableUtilidad = document.getElementById("tabla"), utilidad = 0;       
        
        for(var i = 1; i < tableCapital.rows.length; i++)
        {
            capital = capital + parseInt(tableCapital.rows[i].cells[2].innerHTML);
        }

        for(var i = 1; i < tableDeuda.rows.length; i++)
        {
            deuda = deuda + parseInt(tableDeuda.rows[i].cells[3].innerHTML);
        }

        for(var i = 1; i < tableUtilidad.rows.length; i++)
        {
            utilidad = utilidad + parseInt(tableUtilidad.rows[i].cells[4].innerHTML);
        }

        document.getElementById("capitalClientes").innerHTML = capital;
        document.getElementById("deudaClientes").innerHTML = deuda;
        document.getElementById("utilidades").innerHTML = utilidad;
        
        var cantPrestamos = document.getElementById('tabla').rows.length - 1;
        document.getElementById("cantPrestamos").innerHTML = cantPrestamos; /*Muestra la cantidad de préstamos*/
        
    </script>

@endsection