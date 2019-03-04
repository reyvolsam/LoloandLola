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
			<li><a href="{{ URL::to('citas/publico') }}"><i class="fa fa-clock-o"></i>Agendar Cita</a> </li>
		</ul>
	</div><!--/sidenav-->
	
	<section class="main">
	    <ul class="nav">
        </ul><!--/nav-->
        
        <div class="contenido">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title t_left">Agendar Cita</h4>

                            <div class = "row">
                                <div class = "col-md-3">
                                    <div class = "form-group">
                                        <label for = "cita_date">Fecha</label>
                                        <div class = "input-group">
                                            <input type = "text" class = "form-control" id = "cita_date" uib-datepicker-popup ng-model = "vm.cita.date" is-open = "vm.date_control.opened" datepicker-options = "vm.date_control" ng-required = "true" close-text = "Cerrar" placeholder = "Seleccione una fecha" ng-change = "vm.GetCitasByDate()" />
                                            <span class = "input-group-btn">
                                                <button type = "button" class = "btn btn-secondary" ng-click = "vm.date_control.opened = true">
                                                    <i class = "fa-svg-icon">
                                                        <i class = "fa fa-calendar"></i>
                                                    </i>
                                                </button>
                                            </span><!--/input-group-btn-->
                                        </div><!--/input-group-->
                                    </div><!--/form-group-->
                                </div><!--/col-md-3-->
                            </div><!--/row-->

                            <div class = "row justify-content-md-center">
                                <div class = "col-md-5 ">
                                    <table class = "table">
                                        <thead class="thead-dark">
                                            <th></th>
                                            <th>Selecciona un horario</th>
                                            <th></th>
                                        </thead>
                                        <tbody ng-repeat = "cita in vm.cita.slots_list" ng-init = "cont = $index">
                                            <tr ng-class = "($index % 2 === 0) ? 'table-active' : ''">
                                                <td><b>#@{{ $index+1 }}</b></td>
                                                <td><b>@{{ cita.init_slot }} - @{{ cita.final_slot }}</b></td>
                                                <td>
                                                    <button ng-if = "cita.exist_cita == false && cita.selected == true" type = "button" class = "btn btn-success" ng-click = "vm.DeselectCita($index)"><i class = "fa fa-check"></i></button>
                                                    <button ng-if = "cita.exist_cita == false && cita.selected == false" type = "button" class = "btn btn-secondary" ng-click = "vm.SelectCita($index)"><i class = "fa fa-check"></i></button> 
                                                    <button ng-if = "cita.exist_cita == true" type = "button" class = "btn btn-danger"><i class = "fa fa-close"></i></button> 
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!--/col-md-5-->
                            </div><!--/row-->
            
                            <button ng-if = "vm.cita.slots_list.length > 0" ng-disabled = "vm.cita.selected == null" type = "button" class = "btn btn-success" ng-click = "vm.SaveCita()">Agendar</button>

                        </div><!--/card-body-->
                    </div><!--/card-->
                </div><!--/col-md-12-->
            </div><!--/row-->

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
    <script type="text/javascript" src="{{ asset('statics/js/lib/ui-bootstrap-tpls-2.5.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('statics/js/customs/dating/public.js') }}"></script>

    @yield('js')

</body>
</html>