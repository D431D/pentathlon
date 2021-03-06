<!DOCTYPE html>
<html lang="es">
<head>
    <title>@yield('titulo')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{  HTML::style('css/bootstrap.css');  }}
    {{  HTML::style('css/bootstrap-theme.min.css');  }}
    {{  HTML::style('font-awesome/css/font-awesome.css');  }}
    {{  HTML::style('css/theme.css');  }}
    {{  HTML::script('js/jquery-1.11.1.js'); }}
    {{  HTML::script('js/bootstrap.js'); }}
    @yield('head')
  </head>
  <body>
    @yield('login')
<!-- navbar -->
  <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
              <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="/"><img src="{{ asset('imgs/pdmu.png') }}" alt=""> PDMU</a>
          </div>
          <div class="hidden-xs">
                  <ul class="nav navbar-nav navbar-right">
                      <li id="fat-menu" class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            @if(Auth::id())
                              {{ Elemento::find(Auth::user()->elemento_id)->persona->nombre." ".Elemento::find(Auth::user()->elemento_id)->persona->apellidopaterno }}
                            @endif  
                              <i class="fa fa-user"></i>
                              <i class="fa fa-caret-down"></i>
                          </a>

                          <ul class="dropdown-menu">
                              <li><a href="{{ URL::to('historial'); }}">Mi perfil</a></li>
                              <li class="divider"></li>
                              <li><a class="visible-phone" href="{{ URL::to('settings'); }}"><i class="fa fa-cogs"></i> Settings</a></li>
                              <!-- <li><a class="visible-phone" href="#"><i class="fa fa-clock-o"></i> Historial</a></li> -->
                              <li class="divider"></li>
                              <li><a href="{{ URL::to('logout'); }}"><i class="fa fa-sign-out"></i> Logout</a></li>
                          </ul>
                      </li>
                  </ul>
          </div>
      </div>
  </div>
<!-- end navbar --
<div class="navbar-collapse collapse">
  <div id="main-menu">
      <ul class="nav nav-tabs ">
        <li class="active"><a href="#"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
          <li ><a href="{{ URL::to('pagos'); }}"><i class="fa fa-money"></i> <span>Pagos</span></a></li>
          <li ><a href="{{ URL::to('companias'); }}" ><i class="fa fa-map-marker"></i> <span>Companias</span></a></li>
          <li ><a href="{{ URL::to('asistencias/index/1'); }}"><i class="fa fa-calendar"></i> <span>Asistencias</span></a></li>
          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog"></i> Settings <b class="caret"></b></a>
              <ul class="dropdown-menu">
                  <li><a href="#"><span>Sign-in Page</span></a></li>
                  <li><a href="#"><span>Sign-up Page</span></a></li>
                  <li><a href="#"><span>Forgot Password Page</span></a></li>
              </ul>
          </li>
      </ul>
  </div>
</div>
-- sidenavbar -->
  <div id="sidebar-nav" class="hidden-xs">
      <ul id="dashboard-menu" class="nav nav-list">
        @if(!is_null(User::find(Auth::id())->roles()->where('id','=',2)->first()))
          <li id="Enteros"><a rel="tooltip" data-placement="right" data-original-title="Dashboard" href="{{ URL::to('pagos'); }}"><i class="fa fa-money"></i> <span class="caption">Enteros</span></a></li>
        @endif  
        @if(!is_null(User::find(Auth::id())->roles()->where('id','=',4)->first()))
          <li id="Companias"><a rel="tooltip" data-placement="right" data-original-title="Reports" href="{{ URL::to('companias'); }}"><i class="fa fa-map-marker"></i> <span class="caption">Companias</span></a></li>
        @endif
        @if(!is_null(User::find(Auth::id())->roles()->where('id','=',3)->first()))
          <li id="Condecoraciones"><a rel="tooltip" data-placement="right" data-original-title="UI Features" href="{{ URL::to('condecoraciones'); }}"><i class="fa fa-shield"></i> <span class="caption">Condecoraciones</span></a></li>
        @endif
        @if(!is_null(User::find(Auth::id())->roles()->where('id','=',3)->first()))
          <li id="Eventos"><a rel="tooltip" data-placement="right" data-original-title="Pricing" href="{{ URL::to('eventos'); }}"><i class="fa fa-calendar-o"></i> <span class="caption">Eventos</span></a></li>
        @endif
          <li id="Examenes"><a rel="tooltip" data-placement="right" data-original-title="Media" href="{{ URL::to('examenes'); }}"><i class="fa  fa-file-text-o"></i> <span class="caption">Examenes</span></a></li>

          <li id="Asistencias"><a rel="tooltip" data-placement="right" data-original-title="Blog" href="{{ URL::to('asistencias'); }}"><i class="fa fa-calendar"></i> <span class="caption">Asistencias</span></a></li>

          <li id="Altas"><a rel="tooltip" data-placement="right" data-original-title="Blog Entry" href="{{ URL::to('recluta/alta'); }}"><i class="fa fa-plus"></i> <span class="caption">Altas</span></a></li>

          <li id="Editar"><a rel="tooltip" data-placement="right" data-original-title="Help" href="{{ URL::to('recluta/editar'); }}"><i class="fa fa-pencil"></i> <span class="caption">Editar</span></a></li>

          <li id="Cargos"><a rel="tooltip" data-placement="right" data-original-title="Faq" href="{{ URL::to('cargos'); }}"><i class="fa fa-magic"></i> <span class="caption">Cargos</span></a></li>
        @if(!is_null(User::find(Auth::id())->roles()->where('id','=',4)->first()))
          <li id="Ascensos"><a rel="tooltip" data-placement="right" data-original-title="Calendar" href="{{ URL::to('ascensos'); }}"><i class="fa fa-line-chart"></i> <span class="caption">Ascensos</span></a></li>
        @endif
          <li id="Arrestos"><a rel="tooltip" data-placement="right" data-original-title="Forms" href="{{ URL::to('arrestos'); }}"><i class="fa fa-gavel"></i> <span class="caption">Arrestos</span></a></li>

          <li id="Armas"><a rel="tooltip" data-placement="right" data-original-title="Tables" href="{{ URL::to('armas'); }}"><i class="fa  fa-crosshairs"></i> <span class="caption">Armas</span></a></li>
          <li id="Cuerpos"><a rel="tooltip" data-placement="right" data-original-title="Mobile" href="{{ URL::to('cuerpos'); }}"><i class="fa fa-child"></i> <span class="caption">Cuerpos</span></a></li>
        @if(!is_null(User::find(Auth::id())->roles()->where('id','<',8)->first()))
          <li id="historial" class=" "><a rel="tooltip" data-placement="right" data-original-title="Icons" href="{{ URL::to('history'); }}"><i class="fa fa-clock-o"></i> <span class="caption">Historial</span></a></li>
         @endif
        <li id="reportes" class=" "><a rel="tooltip" data-placement="right" data-original-title="Icons" href="{{ URL::to('reportes'); }}"><i class="fa fa-bar-chart"></i> <span class="caption">Reportes</span></a></li> 
      </ul>
  </div>
<!-- end sidenavbar -->
    <div class="content">
    @yield('contenido')
      <footer>
          <hr>
          <p class="pull-right"><a href="#" target="_blank">Patria, Honor y Fuerza</a></p>
          <p>2014</p>
      </footer>
    </div>
  </body>


  
  @yield('scripts')
</html>
