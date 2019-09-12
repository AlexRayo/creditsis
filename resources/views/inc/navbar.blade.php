
<nav class="navbar navbar-default" style="text-align:center">        
        <div class="container-fluid col-md-10 col-md-offset-1">
        <div class="navbar-header">
            <a href="{{ url('/dashboard') }}"><img src="{{ asset('img/logo.jpg')}}" alt="" style="margin-top:-10px; width: 125px; border-radius: 50%;"></a>
        </div>
            <ul class="nav navbar-nav pull-right" style="text-align: right">
                <li><a class="text-link" href="/clientes">Clientes</a></li>
                <li><a class="text-link" href="/prestamos">Préstamos</a></li>
                <li><a class="text-link" href="/utilidades">Utilidades</a></li>
                <li><a class="text-link" href="/pagos">Pagos</a></li>
                <li>
                    <div><a href="/clientes/create" class="btn btn-primary">Nuevo cliente</a></div>
                </li>    
                <li>
                    <div >
                        @if (Route::has('login'))
                        <div >
                        @auth
                        <!-- Authentication Links -->
                        @guest
                        @else            
                            <a class="btn btn-default fa fa-sign-out" title="Cerrar sesión" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            @endguest
                            @else
                            <!-- <a href="{{ route('login') }}">Login</a>
                            <a href="{{ route('register') }}">Register</a>-->
                            @endauth
                    </div>
                    @endif
                </li>
            </ul>
        </div>    
    </nav>
<style>
    li{list-style: none;margin: 0 20px;}
    nav li{
    line-height: 50px;
    margin-top: 25px
    }
    .text-link{font-size: 18px;}
</style>