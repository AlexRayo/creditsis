@extends('layouts.app')
@section('content')

<div class="col-md-6 text-center">
    <h1>Editar Préstamo</h1>
    <h3>Cliente: <b><a href="/clientes/{{$prestamos->cliente->id}}">{{$prestamos->cliente->nombres}}</a></b></h3>    
</div>

<div class="col-md-6 thumbnail">
    <div class="col-md-12">
        @if (!Auth::guest())               
        @if (Auth::user()->name == "Admin")
        
        <p onclick="showValidationWindow2()" class="fa fa-trash  btn btn-danger pull-right" id="delBtn" title="Elimiar el préstamo"></p>
        
        <div id="validationWindow2" style="display: none;" class="col-lg-12 thumbnail pull-right">        
        <h4 style="color:crimson"><b>Se eliminará todo el registro del prestamo actual (Incluyendo todos los pagos realizados)</b></h4 style="color:crimson">
        <div>
                <p id="hideValWin" onclick="hideValidationWindow2()"class="okBtn DefBtn btn btn-primary pull-right">Cancelar</p>
            {!!Form::open(['action' => ['PrestamoController@destroy', $prestamos->id], 'method' => 'POST', 'class' => '' ])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Eliminar', ['class'=>'btn btn-default'])}}            
            {!!Form::close()!!}
        </div>
    </div> 
        @endif
        @endif  
            <form action="{{route('prestamo.update', $prestamos->id)}}" method="POST">
                
                <input  type="hidden" id="idCliente" name="cliente_id" class="form-control" required readonly value="{{$prestamos->cliente->id}}"><br>                    
    
                <label class="col-md-12 control-label">Monto</label>
                <input value="{{$prestamos->monto}}" type="number" id="monto" name="monto" class="form-control" placeholder="Ingrese el monto del préstamo" onkeyup="calcularCuotaMensual()" required step="any" min="0"><br>
                
                <label class="col-md-12 control-label">Interés</label>
                <input  value="{{$prestamos->interes}}" id="interes" name="interes" class="form-control" placeholder="tasa de interes" onkeyup="calcularCuotaMensual()" required><br>
                
                <label class="col-md-12 control-label">Abonos al capital</label>
                <input type="" id="abonado"class="form-control"readonly><br>

                <label class="col-md-12 control-label">Saldo Anterior</label>
                <input value="@if($prestamos->saldo===NULL) {{$prestamos->monto}}
                                @else {{$prestamos->saldo}}
                                @endif"  id="saldoAnterior" class="form-control" required readonly><br>
               
                <label class="col-md-12 control-label">Nuevo Saldo</label>
                <input id="nuevoSaldo" name="nuevoSaldo" class="form-control" required readonly><br>
                
                <label class="col-md-12 control-label">Valor de la nueva cuota</label>
                <input value=""  id="valor_cuota" name="valor_cuota" class="form-control" required readonly><br>

                <div class="form-group col-md-12">
                    <label class="col-md-6 control-label">Fecha de solicitud</label>
                    <input type="date" value="{{$prestamos->fecha_entrega}}" name="fecha_entrega" class="form-control col-md-5" required />
                </div>

                <div class="form-group col-md-12">
                    <label class="col-md-6 control-label">Día de pago</label>
                <input type="number" name="dia_pago" class="form-control input-md" value="{{$prestamos->dia_pago}}" required min="01" max="31"/>
                </div> 

                <label class="col-md-6 control-label" for="cliente">Notas</label>
                <textarea name="notas" class="form-control" placeholder="Notas" required>{{$prestamos->notas}}</textarea><br>
                    
                <input type="submit" class="btn btn-primary" value="Actualizar préstamo">
                {{ csrf_field()}} 
            </form>
        </div>
    </div>
  
<script src="{{asset('my_vendor/js/editarPrestamo.js')}}"></script>
<script>window.onload = fechaCuotaEditPrestamo;</script>  
@endsection
<style>select{height: 40px !important;}</style>
