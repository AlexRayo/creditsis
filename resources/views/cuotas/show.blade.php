@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 thumbnail">

        <p>Nº de la cuota: <b>{{$cuota->num_cuota}}</b></p>
        <p>Cantidad de la cuota: <b>U$&nbsp;{{$cuota->cuota}}</b></p>
        <p>Fecha de la cuota: <b>{{$cuota->fecha_cuota}}</b></p>
        <p>Notas: <b>{{$cuota->notas}}</b></p>
        <br>
        <a href="/prestamos/{{$cuota->id}}/edit" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Editar</a><!--Se le pasa el id del post actual con cuota id y Abre el archivo 'edit' -->
        <p onclick="showValidationWindow()" class="btn btn-danger pull-right" id="delBtn">Eliminar</p>
        
        <div id="validationWindow" style="display: none;" class="col-lg-6 thumbnail pull-right">
            <h4 style="color:crimson"><b>Desea eliminar la cuota?</b></h4 style="color:crimson">
            <div>
                <p id="hideValWin" onclick="hideValidationWindow()"class="okBtn DefBtn btn btn-primary">Cancelar</p>
            {!!Form::open(['action' => ['PrestamoController@destroy', $cuota->id], 'method' => 'POST', 'class' => 'pull-right' ])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Eliminar', ['class'=>'btn btn-default'])}}            
            {!!Form::close()!!}
            </div>           
        </div>
        
    </div>
</div>
  
@endsection