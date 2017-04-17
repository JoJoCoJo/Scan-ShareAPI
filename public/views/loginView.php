<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<link rel="stylesheet" type="text/css" href="/css/materialize.css">
	<link rel="stylesheet" type="text/css" href="/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="/sweetalert2/sweetalert2.css">
	<link rel="stylesheet" type="text/css" href="/css/main.css">

	<title> Login | Plataforma </title>

	<script type="text/javascript" src="/js/jquery-2.1.1.js"></script>
	<script type="text/javascript" src="/js/materialize.js"></script>
	<script type="text/javascript" src="/sweetalert2/sweetalert2.js"></script>
	
	<script type="text/javascript" src="/js/login.js"></script>
</head>
<body class="banner">
	<div class="center-content">
		<div class="panel-login card-panel white">
			<div class="card-content black-text">
              <span class="card-title blue-text"><h4 style="text-align: center;">Scan & Share</h4></span>
				<div class="row">
					<form class="col s12" id="formLogin" name="formLogin">
						<div class="row">
							<div class="input-field col s12">
						        <i class="fa fa-at prefix" aria-hidden="true"></i>
						        <input id="emailLogin" name="emailLogin" type="text" class="validate" value="jojocojo@msn.com">
						        <label for="emailLogin">Correo:</label>
				        	</div>
				        	<div class="input-field col s12">
						        <i class="fa fa-key prefix" aria-hidden="true"></i>
						        <input id="passwordLogin" name="passwordLogin" type="password" class="validate" value="12345">
						        <label for="passwordLogin">Contraseña:</label>
				        	</div>
						</div>
						<input class="waves-effect waves-light btn-large light-blue" type="submit" value="Ingresar">
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>