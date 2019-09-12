@extends('layouts.app')
@section('content')
<div class="container">
    @if(isset($details))
        <!--<p>El resultado de <b> {{ $query }} </b> es :</p> -->
    <h2>Resultado de la búsqueda del cliente</h2>
    <div class="table-responsive thumbnail">
        <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>zona</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Editar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $cliente)
            <tr>
                <td>{{$cliente->id}}</td>
                <td>{{$cliente->nombres}}</td>
                <td>{{$cliente->zona}}</td>
                <td>{{$cliente->direccion}}</td>
                <td>{{$cliente->telefono}}</td>
                <td>
                    <a href="/clientes/{{$cliente->id}}" class="fa fa-gear btn btn-primary" title="Ver/Editar"></a>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    </div>
</div>
@endsection