<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<!-- compatilibdad con webapp iOS -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="Dpilady">
	<link rel="apple-touch-icon"  href="{{asset('statics/favicon/logo_dpilady_mini.png') }}">

	<!-- compatilibdad con webapp Android -->
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="theme-color" content="#da4469">
	<meta name="application-name" content="Dpilady">
	<link rel="icon" type="image/png" href="{{ asset('statics/favicon/logo_dpilady_mini.png') }}">

	<title>Dpilady ::Depilación Laser::</title>
	<meta name="description" content="Dpilady, depilación laser y toda para tu belleza">
	<meta name="author" description="Nextio"/>

	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('statics/favicon/logo.ico') }}" />

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="{{ asset('statics/css/dpilady.css') }}">

	@yield('css')
</head>
<body ng-app = "app" ng-controller = "appCtrl as vm" ng-cloak class="body_int">

	
	<div id = "sidenav" class = "sidenav animated fadeIn">
		<div class = "logotipo">
			<img src = "{{ asset('statics/images/logo_dpilady_blanco.png') }}" alt = "logotipo">
		</div><!--/logotipo-->
		<ul>
			<li><a href="{{ URL::to('/') }}"><i class="fa fa-home"></i> Escritorio</a> </li>
			@if(\Auth::getUser()->group_id == 1 || \Auth::getUser()->group_id == 2 || \Auth::getUser()->group_id == 3)
			<li><a href="{{ URL::to('user') }}"><i class="fa fa-users"></i> 
				@if(\Auth::getUser()->group_id == 3)
				Clientes
				@else
				Usuarios
				@endif
				</a> 
			</li>				
			<li><a href="{{ URL::to('service') }}"><i class="fa fa-briefcase"></i> Servicios</a> </li>
			<li><a href="{{ URL::to('product') }}"><i class="fa fa-heart"></i> Productos</a> </li>
			@endif
			@if(\Auth::getUser()->group_id == 1 || \Auth::getUser()->group_id == 2)
			<li><a href="{{ URL::to('dating') }}"><i class="fa fa-calendar"></i>Gestión de Citas</a> </li>
			@endif
			@if(\Auth::getUser()->group_id == 1 || \Auth::getUser()->group_id == 2 || \Auth::getUser()->group_id == 3 || \Auth::getUser()->group_id == 4)
			<li><a href="{{ URL::to('citas') }}"><i class="fa fa-clock-o"></i>Agendar Cita</a> </li>
			@endif
			@if(\Auth::getUser()->group_id == 1 || \Auth::getUser()->group_id == 2 || \Auth::getUser()->group_id == 3)
			<li><a href="{{ URL::to('citas/list') }}"><i class="fa fa-calendar-o"></i>Ver Citas</a> </li>
			<li><a href="{{ URL::to('payment2') }}"><i class="fa fa-credit-card"></i>Pagar</a> </li>
			@if(\Auth::getUser()->group_id == 1 || \Auth::getUser()->group_id == 2)
			<li><a href="{{ URL::to('payment2/list') }}"><i class="fa fa-database"></i>Historial</a> </li>
			@endif
			@endif
		</ul>
	</div><!--/sidenav-->
	
	<section class="main">
	    <ul class="nav">
		    <li class="nav-item icon_menu">
                <a id="btn_cerrar_menu" class="nav-link" href="#"><i class="fa fa-bars"></i></a>
                <a id="btn_abrir_menu" class="nav-link" href="#"><i class="fa fa-arrow-right"></i></a>
            </li><!--/nav-item-->
            <li class="right avatar">
                <div class="dropdown">
                    <button class="btn dropdown-toggle animated fadeIn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('statics/images/avatar.png') }}" alt=""> {{\Auth::user()->first_name}} {{\Auth::user()->last_name}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ URL::to('logout') }}"><i class="fa fa-close"></i> Cerrar Sesión</a>
                    </div><!--/dropdown-menu-->
                </div><!--/dropdown-->
            </li><!--/right-->
        </ul><!--/nav-->
        
        <div class="contenido">
                @yield('content')
	    </div><!--/conteniido-->
	</section>
	
	@yield('modal')

    <script type = "text/javascript" src = "{{ asset('statics/js/lib/jquery-3.3.1.min.js') }}"></script>
    <script type = "text/javascript" src = "{{ asset('statics/js/lib/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('statics/js/lib/angular.min.js') }}"></script>
    <script type = "text/javascript" src = "{{ asset('statics/js/lib/main-min.js') }}"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
    <script type = "text/javascript" src="{{ asset('statics/js/lib/sweetalert.min.js') }}"></script>
	<script type = "text/javascript" src = "{{ asset('statics/js/lib/ng-currency.js') }}"></script>
	<script type = "text/javascript" src = "{{ asset('statics/js/lib/angular-locale_es-mx.js') }}"></script>

    <script type="text/javascript">
        $(document).on('ready', function (){
          
          $('#logout_system').on('click', function (){
      
            swal('¡Éxito!', 'Hasta Pronto.', 'success');
            window.location = "{{ URL::to('logout') }}";
          });
      
        });
    </script>

    @yield('js')

</body>
</html>