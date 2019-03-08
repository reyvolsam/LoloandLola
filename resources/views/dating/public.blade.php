<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<!-- compatilibdad con webapp iOS -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="Dpilady">
	<link rel="apple-touch-icon"  href="https://dpilady.com/mx/wp-content/themes/dpilady/favicon/logo.png">

	<!-- compatilibdad con webapp Android -->
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="theme-color" content="#da4469">
	<meta name="application-name" content="Dpilady">
	<link rel="icon" type="image/png" href="https://dpilady.com/mx/wp-content/themes/dpilady/favicon/logo.png">

	<title>Citas Dpilady</title>
	<meta name="description" content="Depilción Laser">
	<meta name="author" description="Iktec"/>

	<link href="//www.google-analytics.com" rel="dns-prefetch">

	<link rel="shortcut icon" type="image/x-icon" href="https://dpilady.com/mx/wp-content/themes/dpilady/favicon/logo.ico" />

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />

	<link rel="stylesheet" type="text/css" href="https://dpilady.com/mx/wp-content/themes/dpilady/style.css">
</head>
<body ng-app = "app" ng-controller = "appCtrl as vm" ng-cloak>

	<section class="topmenu">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12 head_social">
					<a href="tel:9211626048"> <i class="fa fa-phone"></i> 01 921 162 6048</a>
					<a href="tel:9211676768"><i class="fa fa-whatsapp"></i> 921 167 67 68 <!-- <span>Lunes a Sábado de 9:00 am a 7:00 pm</span> -->  </a>
					<a href="https://www.facebook.com/Dpilady/" target="_blank"><i class="fa fa-facebook-square"></i> Dpilady </a>
					<a href="http://dpilady.com/dpilady/public/login" target="_blank"><i class="fa fa-laptop"></i></a>
				</div><!--/row-->
			</div><!--/row-->
		</div><!--/container-->
	</section>
	<section class="topmenulogo">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12 logo">
					<a href="/"><img src="https://dpilady.com/mx/wp-content/themes/dpilady/images/logo_dpilady.png"  alt=""></a>
				</div><!--/col-sm-12-->
			</div><!--/row-->
		</div><!--/container-->
	</section>
	<nav>
    	<div class="container">
			<ul id="nav-mobile" class="center hide-on-med-and-down">
				<li><a href="/">Inicio</a></li>
				<li><a href="#">Servicios</a></li>
				<li><a href="#">Productos</a></li>
				<li><a href="tel:9211626048" target="_blank">Contacto</a></li>
				<li><a href="/mx/citas/">Agenda tu cita</a></li>
			</ul><!--/nav-mobile-->

      		<ul id="slide-out" class="sidenav">
	    		<li>
					<div class="user-view">
						<div class="background">
							<img src="https://dpilady.com/mx/wp-content/themes/dpilady/images/sidenav.jpg">
						</div><!--/background-->
					</div><!--/user-view-->
				</li>
				<li><a href="/">Inicio</a></li>
				<li><a href="#">Servicios</a></li>
				<li><a href="#">Productos</a></li>
				<li><a href="tel:9211626048" target="_blank">Contacto</a></li>
				<li><a href="/mx/citas/">Agenda tu cita</a></li>
	  		</ul>
	  		<a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    	</div><!--/containerr-->
	</nav>

	<section id="citas" class="citas">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<h3 class="t_center">Agenda tu cita</h3>
					<div class="minidivider"></div>
					<p class="t_center">Déjanos tus datos básicos para agendar una cita y selecciona el día que puedas asistir</p> <br>
				</div><!--/col-sm-12-->
			</div><!--/row-->
			<div ng-if = "vm.loader == true" class = "row col-md-3 offset-md-5">
				<p><i class = "fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i></p>
				<div class = "clearfix"></div>
				<p>Guardando cita...</p>
			</div>
			<div ng-if = "vm.loader == false" class="row">
				<div class = "col-sm-12 col-md-2">
				</div><!--/row-->
				<div class = "col-sm-12 col-md-8 formulario">
					<form class = "">
						<div class = "row">
							<div class = "input-field col-sm-12 col-md-4">
								<input type = "text" placeholder = "Nombre" id = "" class = "validate" ng-model = "vm.cita.name">
							</div><!--/input-field-->
							<div class = "input-field col-sm-12 col-md-4">
								<input type = "text" placeholder = "Teléfono" id = "" class = "validate" ng-model = "vm.cita.phone">
							</div><!--/input-field-->
							<div class = "input-field col-sm-12 col-md-4">
								<input type = "text" id = "cita_date" uib-datepicker-popup ng-model = "vm.cita.date" is-open = "vm.date_control.opened" datepicker-options = "vm.date_control" ng-required = "true" close-text = "Cerrar" ng-click = "vm.date_control.opened = true" ng-change = "vm.GetCitasByDate()" placeholder = "Seleccione una fecha" />
							</div><!--/input-field-->
						</div><!--/row-->
						<div class = "row">
							<div class = "col-sm-12 col-md-12">
								<table class = "table">
                            		<thead class = "thead-dark">
										<tr>
											<th></th>
											<th>Selecciona un horario</th>
											<th></th>
										</tr>
									</thead>
                            		<tbody ng-repeat = "cita in vm.cita.slots_list" ng-init="cont = $index" class="ng-scope">
                                		<tr ng-class = "($index % 2 === 0) ? 'table-active' : ''">
											<td><b>#@{{ $index+1 }}</b></td>
											<td><b>@{{ cita.init_slot }} - @{{ cita.final_slot }}</b></td>
                                    		<td>
												<button ng-if = "cita.exist_cita == false && cita.selected == true" type = "button" class = "btn btn-success" ng-click = "vm.DeselectCita($index)"><i class = "fa fa-check"></i></button>
												<button ng-if = "cita.exist_cita == false && cita.selected == false" type = "button" class = "btn btn-secondary" ng-click = "vm.SelectCita($index)"><i class = "fa fa-check"></i></button> 
											</td>
                                		</tr>
                            		</tbody>
								</table>
								
								<div class = "col-md-3 offset-md-5">
									<i ng-if = "vm.cita.loader == true" class = "fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
								</div>
                    		</div><!--/col-sm-12-->
                    		<div class = "row t_center">
                    			<div class = "input-field col s12 m12">
									<button ng-if = "vm.cita.slots_list.length > 0" ng-disabled = "vm.cita.selected == null" type = "button" class = "btn btn-large btn_dpilady" ng-click = "vm.SaveCita()"><i class = "fa fa-calendar"></i> Agendar</button> <br><br><br>
								</div><!--/input-filed-->
                    		</div><!--/row-->
						</div><!--/row-->
					</form>
				</div><!--/col-sm-12-->
				<div class="col-sm-12 col-md-2"></div>
			</div><!--/row-->
		</div><!--/container-->
	</section>

	<footer>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<p>Derechos reservados © 2019 D´pilady.com</p>
				</div><!--/col-sm-12-->
			</div><!--/row-->
		</div><!--/containere-->
	</footer>

	<!-- JavaScript -->
	<script type="text/javascript" src="https://dpilady.com/mx/wp-content/themes/dpilady/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="https://dpilady.com/mx/wp-content/themes/dpilady/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
	<script type="text/javascript" src="{{ asset('statics/js/lib/angular.min.js') }}"></script>
	<script type = "text/javascript" src = "{{ asset('statics/js/lib/angular-locale_es-mx.js') }}"></script>
	<script type="text/javascript" src="{{ asset('statics/js/lib/ui-bootstrap-tpls-2.5.0.min.js') }}"></script>
	<script type = "text/javascript" src="{{ asset('statics/js/lib/sweetalert.min.js') }}"></script>

	<script type="text/javascript">
	angular.module('app', ['ui.bootstrap']).controller('appCtrl', ['$http', index_init]);

		function index_init($http){
			var vm = this

			vm.loader = false

			vm.date_control = {
				dateDisabled: false,
				formatYear: 'yyyy',
				maxDate: new Date(2020, 5, 22),
				minDate: new Date(),
				startingDay: 1,
				opened: false
			}

			vm.cita = {}
			vm.cita.date = null
			vm.cita.name = ''
			vm.cita.phone = ''
			vm.cita.slots_list = []
			vm.cita.selected = null
			vm.cita.loader = false
			

			vm.GetCitasByDate = _ =>
			{
				vm.cita.selected = null
				
				if(typeof vm.cita.date !== 'undefined'){
					let dd = vm.cita.date
					let d = new Date(dd.getFullYear(), dd.getMonth(), dd.getDate())
					let final_date = dd.getFullYear()+'-'+('0'+(dd.getMonth()+1)).slice(-2)+'-'+('0'+dd.getDate()).slice(-2)
					vm.cita.slots_list = [];
					vm.cita.loader = true
					$http.post('get_public_citas', { day: d.getDay(), date: final_date })
					.success(res =>{
						console.log(res)
						vm.cita.loader = false
						if(res.status){
							vm.cita.slots_list = res.data
							for(let i in vm.cita.slots_list){
								vm.cita.slots_list[i].init_slot = vm.ConvertTo12H(vm.cita.slots_list[i].init_slot)
								vm.cita.slots_list[i].final_slot = vm.ConvertTo12H(vm.cita.slots_list[i].final_slot)
							}
						} else {
							swal('¡Atención!', res.msg, 'warning')
						}
					}).error(res=>{
						console.log(res)
						vm.cita.loader = false
						swal('¡Error!', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
					})
				} else {
					console.log('ES UNDEFINED')
					vm.cita.slots_list = []
				}
			}//vm.GetCitasByDate

			vm.SelectCita = ind =>
			{
				if(vm.cita.selected === null){
					vm.cita.slots_list[ind].selected = true
					vm.cita.selected = vm.cita.slots_list[ind]
					vm.cita.selected.name = vm.cita.name
					vm.cita.selected.phone = vm.cita.phone
					vm.cita.selected.ind = ind
				}
			}//

			vm.DeselectCita = ind =>
			{
				vm.cita.slots_list[ind].selected = false
				vm.cita.selected = null
			}//vm.DeselectCita

			vm.SaveCita = _ =>
			{    
				if(vm.cita.selected != null && vm.cita.name.length > 0 && vm.cita.phone.length > 0 ){
					vm.cita.selected.date = vm.ConvertToSimpleDate(vm.cita.date)
					vm.loader = true
					$http.post('save_public_cita', vm.cita.selected)
					.success(res =>{
						console.log(res)
						vm.loader = false
						if(res.status){
							vm.cita = {}
							vm.cita.date = null
							vm.cita.name = null
							vm.cita.phone = null
							vm.cita.slots_list = []
							vm.cita.selected = null
							swal('Éxito', res.msg, 'success')
						} else {
							swal('Atención', res.msg, 'warning')
						}
					}).error(res => {
						console.log(res)
						vm.loader = false
						swal('Error', 'Ups! Algo salio mal, recarga de nuevo la pagina y vuelve a intentarlo.', 'error')
					})
				} else {
					swal('Atención', 'Todos los campos son obligatorios.', 'warning')
				}
			}//vm.MakeCitas


			////////////////////////////////////////
			vm.ConvertToSimpleDate = dd =>
			{
				let d = new Date(dd.getFullYear(), dd.getMonth(), dd.getDate())
				let final_date = dd.getFullYear()+'-'+('0'+(dd.getMonth()+1)).slice(-2)+'-'+('0'+dd.getDate()).slice(-2)
				return final_date
			}//vm.ConvertToSimpleDate
	
			vm.ConvertTo12H = v =>
			{
				let t = v.split(':')

				time = ('0'+t[0]).slice(-2)+':'+('0'+t[1]).slice(-2)

				time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];
			
				if (time.length > 1) {
				time = time.slice (1)
				time[5] = +time[0] < 12 ? 'AM' : 'PM'
				time[0] = +time[0] % 12 || 12
				}
				return time.join ('')
			}//

		}////
	</script>
</body>
</html>