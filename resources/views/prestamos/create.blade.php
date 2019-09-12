@extends('layouts.app')
@section('content')
    
    <div class="col-md-6 text-center">
        <h1>Nuevo Préstamo</h1>
        <h3>Cliente: <b><a href="/clientes/{{$cliente->id}}">{{$cliente->nombres}}</a></b></h3>
    </div>
        <div class="col-md-6 thumbnail">
            <form action="{{route('prestamo.store')}}" method="POST"> 
            <input type="hidden" name="cliente_id" value="{{$cliente->id}}">                           
                        
                <label class="col-md-6 control-label">Monto</label>
                <input type="number" id="monto" name="monto" class="form-control" placeholder="Ingrese el monto del préstamo" onkeyup="calcularCuotaMensual()" required step="any" min="0"><br>
                
                <label class="col-md-6 control-label">Porcentaje de interés</label>
                <input id="interes" name="interes" class="form-control" placeholder="15 como máximo" onkeyup="calcularCuotaMensual()" type="number" required step="any" min="0" max="15"><br>

                <label class="col-md-6 control-label">Interés a pagar cada mes</label>
                <input id="valor_cuota" name="valor_cuota" class="form-control" required readonly><br>

                <input type="hidden" id="saldo" name="saldo" class="form-control" required readonly><br>
                <div class="form-group">
                <label class="col-md-6 control-label">Fecha de entrega</label>
                    <div class="col-md-5">
                        <input id="fecha_inicio" type="date" name="fecha_entrega" class="form-control input-md" onchange="calcularCuotaMensual()" required value=<?php echo '"' . date('Y-m-d') . '"';?>/>
                    </div>
                </div>    
                <br>
                <br>
                <!-- -->
                <div class="form-group">
                    <label class="col-md-6 control-label">Día de pago</label>
                    <div class="col-md-5">
                        <input type="number" name="dia_pago" class="form-control input-md" required min="01" max="31"/>
                    </div>
                </div> 
                <input type="hidden" id="nuevoSaldo" class="form-control" required readonly><br>
                <input type="hidden" id="abonado"class="form-control" value="0" readonly><br>

                <label class="col-md-6 control-label" for="cliente">Notas</label>
                <textarea name="notas" class="form-control" placeholder="Notas" required>Ninguna</textarea><br>
                
                <input type="submit" class="btn btn-primary" value="Agregar préstamo">
                {{ csrf_field()}} <!--Cross Site Request Forgery genera un token de tipo csrf para cada sección
                de usuario autenticado por motivos de seguridad; esto es un campo ocultos -->
            </form>
        </div>


    <script src="{{asset('my_vendor/js/nuevoPrestamo.js')}}"></script>
    <style>select{height: 40px !important;}</style>
@endsection
