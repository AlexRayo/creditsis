@extends('layouts.app')
@section('content')

<div class="col-md-6 text-center">
    <h1>Editar Cliente</h1>
    <h3>Cliente: <b><a href="/clientes/{{$showCliente->id}}">{{$showCliente->nombres}}</a></b></h3>

</div>

<div class="col-md-6 thumbnail"> 
    @if (!Auth::guest())               
    @if (Auth::user()->name == "Admin")        
    <p onclick="showValidationWindow2()" class="fa fa-trash  btn btn-danger pull-right" id="delBtn" title="Borrar al cliente"></p>
                
    <div id="validationWindow2" style="display: none;" class="col-lg-12 thumbnail pull-right">        
        <h4 style="color:crimson"><b>Se eliminará todo el registro del cliente (Incluyendo todos sus datos, préstamos y pagos realizados)</b></h4 style="color:crimson">
        <div>
                <p id="hideValWin" onclick="hideValidationWindow2()"class="okBtn DefBtn btn btn-primary pull-right">Cancelar</p>
            {!!Form::open(['action' => ['ClienteController@destroy', $showCliente->id], 'method' => 'POST', 'class' => '' ])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Eliminar', ['class'=>'btn btn-default'])}}            
            {!!Form::close()!!}
        </div><br><br>
    </div> 
    @endif
    @endif     
    
    <form action="{{route('cliente.update', $showCliente->id)}}" method="POST" enctype="multipart/form-data" style="margin:50px 10px">
        <label>Nombre</label>
        <input type="text" name="nombres" class="form-control" placeholder="Nombre y Apellidos" value="{{$showCliente->nombres}}" required><br>
        <label>Zona</label>
        <select id="cliente" name="zona" class="form-control" onchange="seleccion()" required>
            @if ($showCliente->zona==="NORTE")
                <option selected>NORTE</option>
                <option>SUR</option>
            @else
                <option selected>SUR</option>
                <option>NORTE</option>
            @endif
            
        </select><label>Dirección</label>
        <input type="text" name="direccion" class="form-control" placeholder="Dirección" value="{{$showCliente->direccion}}" required><br>
        <label>Teléfono</label>
        <input type="text" name="telefono" class="form-control" placeholder="Teléfono" value="{{$showCliente->telefono}}" required><br>
        <input type="submit" class="btn btn-primary" value="Actualizar los datos">
        {{ csrf_field()}} <!--Cross Site Request Forgery genera un token de tipo csrf para cada sección
        de usuario autenticado por motivos de seguridad; esto es un campo ocultos -->
        {{method_field('PUT')}}
    </form>
</div>
          
    <style>select{height: 40px !important;}</style>
@endsection