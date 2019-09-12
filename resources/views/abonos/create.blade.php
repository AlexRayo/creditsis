@extends('layouts.app')
@section('content')


<div class="col-md-6 text-center">
    <h1>Abono al capital</h1>
    <h3>Cliente: <b><a href="/clientes/{{$prestamo->cliente->id}}">{{$prestamo->cliente->nombres}}</a></b></h3>    
</div>
    <div class="col-md-6 thumbnail">
        <div class="">  
            <form action="{{route('abono.store')}}" method="POST" id="cuotaPrint">
            <input type="hidden" name="prestamo_id" value="{{$prestamo->id}}">
                <label class="col-md-6 control-label">Valor de la cuota</label>    
                <input type="" id="cuota" name="cuota" class="form-control" placeholder="Cantidad de abono al capital" onkeyup="calcularNuevaCuota()" required step="any" min=""><br>
                
                <label class="col-md-6 control-label">Fecha del abono</label>
                    <div class="col-md-5">
                        <input id="fecha_inicio" type="date" name="fecha_abono" class="form-control input-md" required value=
                        <?php
                        echo '"' . date('Y-m-d') . '"';
                        ?>
                    />
                    </div>
                </div>   
                
                <label class="col-md-6 control-label">Saldo anterior</label>
                <input id="monto" class="form-control" placeholder="" readonly required step="any" min="" value=
                @if($prestamo->saldo===NULL)
                {{$prestamo->monto}}
                @else {{$prestamo->saldo}}
                @endif
                />

                <input type="hidden" value="{{$prestamo->interes}}"  id="interes" class="form-control" placeholder="" readonly required step="any" min=""><br>
                
                <label class="col-md-6 control-label">Nuevo saldo</label>
                <input  id="nuevoSaldo" class="form-control" placeholder="" readonly><br>

                <label class="col-md-6 control-label">Valor de la nueva cuota</label>
                <input  id="nuevaCuota" class="form-control" placeholder="Nueva cuota" readonly><br>

                <label class="col-md-6 control-label">Notas</label>
                <textarea name="notas" class="form-control" cols="30" rows="2">Ninguna</textarea>
                <br>
  
                <input type="submit" class="btn btn-primary col-md-5" value="Abonar al capital">
                <!--  <input type="button" class="btn btn-default col-md-12" value="Imprimir" onclick="printContent('cuotaPrint')">-->
                {{ csrf_field()}}
            </form>
        </div>
    </div>
    <script src="{{asset('my_vendor/js/nuevaCuota.js')}}"></script>
    <script src="{{asset('my_vendor/js/fechaProxCuota.js')}}"></script>
@endsection