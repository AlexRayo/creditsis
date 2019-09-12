@extends('layouts.app')
@section('content')
<div class="col-md-6 text-center">
    <h1>Editar el abono del capital</h1>
    <h3>Cliente: <b><a href="/clientes/{{$prestamo->cliente->id}}">{{$prestamo->cliente->nombres}}</a></b></h3>   
</div>

    <div class="col-md-6 thumbnail">
        <div class="col-md-12">                    
            <p onclick="showValidationWindow2()" class="fa fa-trash  btn btn-danger pull-right" id="delBtn" title="Elimiar el préstamo"></p>
            
            <div id="validationWindow2" style="display: none;" class="col-lg-12 thumbnail pull-right">        
            <h4 style="color:crimson"><b>¿Desea eliminar éste abono?</b></h4 style="color:crimson">
            <div>
                <p id="hideValWin" onclick="hideValidationWindow2()"class="okBtn DefBtn btn btn-primary pull-right">Cancelar</p>
                {!!Form::open(['action' => ['AbonoController@destroy', $abono->id], 'method' => 'POST', 'class' => '' ])!!}
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('Eliminar', ['class'=>'btn btn-default'])}}            
                {!!Form::close()!!}
            </div><br><br>
        </div> 
        <div>  
            <form action="{{route('abono.update', $abono->id)}}" method="POST" id="cuotaPrint">
             
                <label class="col-md-6 control-label">Valor de la cuota</label>    
                <input value="{{$abono->cuota}}" type="" id="cuota" name="cuota" class="form-control" placeholder="Cantidad de abono al capital" onkeyup="calcularNuevaCuota()" required step="any" min=""><br>
                
                <label class="col-md-6 control-label">Saldo anterior</label>
                <input value="{{$abono->prestamo->saldo}}"  id="monto" class="form-control" placeholder="" readonly required step="any" min=""><br>

                <input type="hidden" value="{{$abono->prestamo->interes}}"  id="interes" class="form-control" placeholder="" readonly required step="any" min="">
                
                <label class="col-md-6 control-label">Nuevo saldo</label>
                <input  id="nuevoSaldo" class="form-control" placeholder="" readonly><br>

                <label class="col-md-6 control-label">Valor de la nueva cuota</label>
                <input  id="nuevaCuota" class="form-control" placeholder="Nueva cuota" readonly><br>

                <div class="form-group col-md-12">
                    <label class="col-md-6 control-label">Fecha del abono</label>
                    <input type="date" value="{{$abono->fecha_abono}}" name="fecha_abono" class="form-control col-md-5" required />
                </div>   

                <label class="col-md-6 control-label">Notas</label>
                <textarea name="notas" class="form-control" cols="30" rows="2">{{$abono->notas}}</textarea>
                <br>
                <input type="submit" class="btn btn-primary col-md-5" value="Actualizar">
                
                {{ csrf_field()}}
            </form>
        </div>
    </div>
    <script src="{{asset('my_vendor/js/nuevaCuota.js')}}"></script>
@endsection