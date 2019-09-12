@extends('layouts.app')
@section('content')
    
<div class="col-md-6 text-center">
        <h1>Nuevo cliente</h1>
</div>        
<div class="col-md-6 thumbnail">            
    <form action="{{route('clientes.store')}}" method="POST" enctype="multipart/form-data">
        <label>Nombre</label>
        <input type="text" name="nombres" class="form-control" placeholder="Nombre y Apellidos" required><br>
        
        <label>Zona</label>
        <select id="cliente" name="zona" class="form-control" onchange="seleccion()" required>
            <option selected>NORTE</option>
            <option>SUR</option>

        </select>
        <br>
        <label>Dirección</label>
        <input type="text" value="Pendiente" name="direccion" class="form-control" placeholder="Dirección" required><br>
        
        <label>Teléfono</label>
        <input type="text" value="Pendiente" name="telefono" class="form-control" placeholder="Teléfono" id="phone" required><br>
        
        <input type="submit" class="btn btn-primary" value="Agregar Cliente"><br>
        {{ csrf_field()}} <!--Cross Site Request Forgery genera un token de tipo csrf para cada sección
        de usuario autenticado por motivos de seguridad; esto es un campo ocultos -->

    </form>
</div>

    <style>select{height: 40px !important;}</style>
@endsection