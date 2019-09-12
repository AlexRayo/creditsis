@extends('layouts.app')
@section('content')
<div class="col-md-6 text-center">
<h1>Editar Cuota del interés</h1>    
    <h3>Cliente: <b><a href="/clientes/{{$cuota->prestamo->cliente->id}}">{{$cuota->prestamo->cliente->nombres}}</a></b></h3>

</div>    
    <div class="col-md-6 thumbnail">
        <div class="col-md-12">
            <p onclick="showValidationWindow2()" class="fa fa-trash  btn btn-danger pull-right" id="delBtn" title="Elimiar la cuota"></p>
                
            <div id="validationWindow2" style="display: none;" class="col-lg-12 thumbnail pull-right">        
                <h4 style="color:crimson"><b>¿Desea eliminar la cuota?</b></h4 style="color:crimson">
                <div>
                        <p id="hideValWin" onclick="hideValidationWindow2()"class="okBtn DefBtn btn btn-primary pull-right">Cancelar</p>
                    {!!Form::open(['action' => ['CuotaController@destroy', $cuota->id], 'method' => 'POST', 'class' => '' ])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Eliminar', ['class'=>'btn btn-default'])}}            
                    {!!Form::close()!!}
                </div><br><br>
            </div>  
            <form action="{{route('cuota.update', $cuota->id)}}" method="POST">

                <label class="col-md-12 control-label">Valor de la cuota</label>
                <input value="{{$cuota->cuota}}" type="number" id="cuota" name="cuota" class="form-control" placeholder="Ingrese el valor de la cuota" onkeyup="calcularNuevaCuota()" required step="any" min="{{$prestamo->valor_cuota}}" max="{{$prestamo->total_cancelar}}"><br>
                                
                <label class="col-md-6 control-label">Fecha de la cuota</label>
                <input type="date" value="{{$cuota->fecha_cuota}}" name="fecha_cuota" class="form-control col-md-5" required />
                <br><br><br><br>
                <input type="submit" class="btn btn-primary col-md-6" value="Actualizar">         
            {{ csrf_field()}}
            </form>
        </div>
</div>   
    <script src="{{asset('my_vendor/js/fechaProximaCuota.js')}}"></script>
@endsection