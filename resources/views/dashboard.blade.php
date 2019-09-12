@include('layouts.basic')
    <body style="text-align:center">
       
        

            <div class="content">
                    <a class="" href="{{ url('/dashboard') }}">
                        <img src="{{ asset('img/logo.jpg')}}" alt="" style="width: 200px; border-radius: 50%">
                    </a>
                    <div style="text-align:right;margin-right:100px">
                            
                        </div>
                <div class="title m-b-md">
                    <h1>Sistema de préstamos</h1>
                </div>
                <div>
                    <ul>
                        <li class="col-md-3"><a class="thumbnail" href="/clientes"><span class="glyphicon glyphicon-user"></span><br><p class="text">Clientes</p></a></li>
                        <li class="col-md-3"><a class="thumbnail" href="/pagos"><span class="glyphicon glyphicon-list-alt"></span><br><p class="text">Pagos</p></a></li>
                        <li class="col-md-3"><a class="thumbnail" href="/utilidades"><span class="glyphicon glyphicon-file"></span><br><p class="text">Utilidades</p></a></li>
                        <li class="col-md-3"><a class="thumbnail" href="/clientes/create"><span class="glyphicon glyphicon-plus-sign"></span><br><p class="text">Nuevo cliente</p></a></li>
                    </ul>
                </div>     
            </div>
        </div>
    </body>
<style>
body { margin: 50px 0;}
h1 { margin-bottom: 1em;}
li { list-style: none;}
a { padding: 50px 0 !important; font-size: 18px}

</style>
</html>

