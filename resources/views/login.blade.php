<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<!-- compatilibdad con webapp iOS -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="Lolo & Lola Boutique">
	<link rel="apple-touch-icon"  href="{{asset('statics/favicon/logo_dpilady_mini.png') }}">

	<!-- compatilibdad con webapp Android -->
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="theme-color" content="##2c1b19">
	<meta name="application-name" content="Lolo & Lola Boutique">
	<link rel="icon" type="image/png" href="{{ asset('statics/favicon/logo_dpilady_mini.png') }}">

	<title>Lolo & Lola Boutique ::Depilación Laser::</title>
	<meta name="description" content="Lolo & Lola Boutique">
	<meta name="author" description="Nextio"/>

	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('statics/favicon/logo.ico') }}" />

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="{{ asset('statics/css/dpilady.css') }}">
</head>
<body ng-app = "app" ng-controller = "appCtrl as vm" ng-cloak>

	<div class="login">
		<img src="statics/images/logo_dpilady.png" height="20px" alt=""><br><br><br>
	<form ng-submit = "vm.SubmitLogin()">
		<div class="form-group row">
			<label class="col-sm-3 col-form-label t_right">Usuario</label>
			<div class="col-sm-9">
			  <input ng-disabled = "vm.loader" type = "email" class="form-control" id = "email" name = "email" ng-model = "vm.login_data.email" placeholder = "Usuario" />
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 col-form-label t_right">Contraseña</label>
			<div class="col-sm-9">
			  <input ng-disabled = "vm.loader" type = "password" class="form-control" id = "passwd" name = "passwd" ng-model = "vm.login_data.passwd" placeholder = "Contraseña" />
			</div>
		</div><br>
		<i ng-if = "vm.loader" class = "fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
		<button ng-if = "vm.loader == false" type = "submit" class="btn btn-lg btn_dpilady">Entrar al Sistema</button><br>
	</form>
	</div>
	

	<script type = "text/javascript" src = "{{ asset('statics/js/lib/jquery-3.3.1.min.js') }}"></script>
	<script type = "text/javascript" src = "{{ asset('statics/js/lib/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('statics/js/lib/angular.min.js') }}"></script>
	<script type = "text/javascript" src = "{{ asset('statics/js/lib/main-min.js') }}"></script>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
	<script type="text/javascript" src="{{ asset('statics/js/lib/sweetalert.min.js') }}"></script>

	<script type="text/javascript" src="{{ asset('statics/js/customs/login.js') }}"></script>

</body>
</html>