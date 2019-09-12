@extends('layouts.app')
@section('content')
<div class="col-md-6 text-center">
    <h1>Nueva cuota</h1>
    <h4>Cliente: <b><a href="/clientes/{{$prestamo->cliente->id}}"> {{$prestamo->cliente->nombres}}</a></b></h4>
    <b><a href="/prestamos/{{$prestamo->id}}"> Ver detalle del préstamo</a></b>
</div>

    <div class="col-md-6 thumbnail">
        <div class="">  
            <form action="{{route('cuota.store')}}" method="POST" id="cuotaPrint">
                <div class="">                   
                    @foreach($clientes as $cliente)
                        @if($cliente->id === $prestamo->cliente_id)
                            <h3 class="thumbnail" style="text-align: center">{!! $cliente->nombres !!}</h3>
                        @endif
                    @endforeach                   
                    <input  type="hidden" id="idCliente" name="prestamo_id" class="form-control" value="{{$prestamo->id}}" required readonly><br>
                   
                </div>
                <label class="col-md-6 control-label">Valor de la cuota (Interés mensual)</label>
                <input value="@if ($prestamo->saldo===NULL)
                {{$prestamo->monto*($prestamo->interes/100)}}
                @else {{$prestamo->valor_cuota}}        
                @endif" type="" name="cuota" class="form-control" placeholder="Cuota sugerida = U$ {{$prestamo->valor_cuota}}" onkeyup="calcularNuevaCuota()" onkeyup="soloNum(this)" required step="any" min=""><br>

                <label class="col-md-6 control-label" for="fecha_inicio">Fecha de la cuota</label>
                    <div class="col-md-5">
                        <input type="date" name="fecha_cuota" class="form-control input-md" onchange="fechaProxCuotaC()" type="text" required value= <?php echo '"' . date('Y-m-d') . '"'; ?> />
                    </div>
                </div>
 
                <input type="submit" class="btn btn-primary col-md-5" value="Agregar cuota">
                
                {{ csrf_field()}}
            </form>
        </div>
    </div>
    <script src="{{asset('my_vendor/js/fechaProximaCuota.js')}}"></script>
@endsection