<?php session_start(); 
	include '../parts/checar_sesion.php';
	if ($nivelUsuario != 1) {
		echo "<html><meta charset=\"utf-8\"><script>alert ('No cuenta con los permisos para ingresar a está página,\\nConsulte al administrador.')</script><body style=\"display:none\"></body></html>";
		header('refresh:.1; url=/../views/menuView.php');
	}else{
?>
<!DOCTYPE html>
<html>
<head>
	
	<link rel="stylesheet" type="text/css" href="/css/materialize.css">
	<link rel="stylesheet" type="text/css" href="/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="/sweetalert2/sweetalert2.css">
	<link rel="stylesheet" type="text/css" href="/DataTables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="/css/main.css">

	<title>Usuarios | Plataforma</title>

	<script type="text/javascript" src="/js/jquery-2.1.1.js"></script>
	<script type="text/javascript" src="/js/materialize.js"></script>
	<script type="text/javascript" src="/sweetalert2/sweetalert2.js"></script>
	<script type="text/javascript" src="/DataTables/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="/js/MeasureTool.js"></script>
	<script type="text/javascript" src="/js/qrcode.js"></script>

	<script type="text/javascript" src="/js/usuarios.js"></script>
</head>
<body class="banner">
	<header>
	<?php include '../parts/navbar.php'; ?>
	</header>
	<div class="container">
		<div class="row">
			<h1 class="center white-text">Usuarios</h1>
		</div>
		<div class="fixed-action-btn">
		  <a class="btn-floating btn-large green tooltipped" data-position="left" data-delay="50" data-tooltip="Agregar" onclick="abrirModalAgregar();">
		    <i class="fa fa-plus" aria-hidden="true"></i>
		  </a>
		</div>
		<!-- Modal Structure Registro -->
		  <div id="agregarRegistro" class="modal modal-fixed-footer" style="overflow: hidden;">
		    <div class="modal-content">
			<a class="btn-large btn-flat right" onclick="cerrarModal();"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
		    <h4>Registrar un nuevo Usuario</h4>
		      <form class="col s12" id="formRegistroUsuario" name="formRegistroObjetivo">
		      	<div class="row">
  					<div class="input-field col s6">
  				        <i class="fa fa-user prefix" aria-hidden="true"></i>
  				        <input id="nameUsuario" name="nameUsuario" type="text" class="validate" data-length="100" maxlength="100">
  				        <label for="nameUsuario">Nombre(s):</label>
  		        	</div>
  		        	<div class="input-field col s6">
  				        <i class="fa fa-font prefix" aria-hidden="true"></i>
  				        <input id="lastnameUsuario" name="lastnameUsuario" type="text" class="validate" data-length="100" maxlength="100">
  				        <label for="lastnameUsuario">Apellido(s):</label>
  		        	</div>
  		        	<div class="col s6">
		        		<label><strong>Tipo de usuario:</strong></label>
				        <select id="roleUsuario" name="roleUsuario">
			              <option value="" disabled selected>Elija una opción...</option>
			              <option value="1">Administrador</option>
			              <option value="2">Usuario Admin</option>
			              <option value="3">Usuario App</option>
			            </select>
		        	</div>
		        	<div class="input-field col s6">
				        <i class="fa fa-calendar prefix" aria-hidden="true"></i>
				        <input id="datepicker" name="datepicker" type="text" class="datepicker" data-length="10" maxlength="10">
				        <label for="datepicker">Fecha Nacimiento:</label>
		        	</div>
    	        	<div class="input-field col s12">
    			        <i class="fa fa-envelope prefix" aria-hidden="true"></i>
    			        <input id="emailUsuario" name="emailUsuario" type="text" class="validate" data-length="100" maxlength="100">
    			        <label for="emailUsuario">Correo:</label>
    	        	</div>
  		        	<div class="input-field col s6">
  				        <i class="fa fa-key prefix" aria-hidden="true"></i>
  				        <input id="passOneUsuario" name="passOneUsuario" type="password" class="validate" data-length="100" maxlength="100">
  				        <label for="passOneUsuario">Contraseña:</label>
  		        	</div>
    	        	<div class="input-field col s6">
    			        <i class="fa fa-key prefix" aria-hidden="true"></i>
    			        <input id="passTwoUsuario" name="passTwoUsuario" type="password" class="validate" data-length="100" maxlength="100">
    			        <label for="passTwoUsuario">Repita la Contraseña:</label>
    	        	</div>
		        	<!-- <div class="file-field input-field col s12">
		        	  <div class="btn blue">
		        	    <span>Imagen</span>
		        	    <input type="file">
		        	  </div>
		        	  <div class="file-path-wrapper">
		        	    <input class="file-path validate" type="text">
		        	  </div>
		        	</div> -->
		      	</div>
		      </form>
		    </div>
		    <div class="modal-footer">
		      <a class="btn-floating btn-medium green right tooltipped" data-position="bottom" data-delay="50" data-tooltip="Guardar Registro" onclick="agregarUsuario();"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
		    </div>
		  </div>
		<div class="row">
			<div class="col s12">
				<div class="card-panel white">
					<div class="card-content black-text">
						<div class="row">
							<table id="dataTable" class="display striped" cellspacing="0" width="100%">
								<thead>
						            <tr>
						                <th>Nombre(s)</th>
						                <th>Apellido(s)</th>
						                <th>Correo</th>
						                <th>Fecha Nacimiento</th>
						                <th>Acciones</th>
						            </tr>
						        </thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Structure Actualizar -->
	  <div id="actualizarRegistro" class="modal modal-fixed-footer" style="overflow: hidden;">
	    <div class="modal-content">
		<a class="btn-large btn-flat right" onclick="cerrarModal();"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
	    <h4>Actualizar Usuario</h4>
	      <form class="col s12" id="formActualizarUsuario" name="formActualizarUsuario">
	      <input id="idUsuarioActualizar" name="idUsuarioActualizar" type="text" hidden>
	      	<div class="row">
				<div class="input-field col s6">
			        <i class="fa fa-user prefix" aria-hidden="true"></i>
			        <input id="nameUsuarioActualizar" name="nameUsuarioActualizar" type="text" class="validate" data-length="100" maxlength="100" value=" ">
			        <label for="nameUsuarioActualizar">Nombre(s):</label>
	        	</div>
	        	<div class="input-field col s6">
			        <i class="fa fa-font prefix" aria-hidden="true"></i>
			        <input id="lastnameUsuarioActualizar" name="lastnameUsuarioActualizar" type="text" class="validate" data-length="100" maxlength="100" value=" ">
			        <label for="lastnameUsuarioActualizar">Apellido(s):</label>
	        	</div>
	        	<div class="col s6">
	        		<label><strong>Tipo de usuario:</strong></label>
			        <select id="roleUsuarioActualizar" name="roleUsuarioActualizar">
		              <option value="" disabled selected>Elija una opción...</option>
		              <option value="1">Administrador</option>
		              <option value="2">Usuario Admin</option>
		              <option value="3">Usuario App</option>
		            </select>
	        	</div>
	        	<div class="input-field col s6">
			        <i class="fa fa-calendar prefix" aria-hidden="true"></i>
			        <input id="datepickerActualizar" name="datepickerActualizar" type="text" class="datepicker" data-length="10" maxlength="10" value=" ">
			        <label for="datepickerActualizar">Fecha Nacimiento:</label>
	        	</div>
	        	<div class="input-field col s12">
			        <i class="fa fa-envelope prefix" aria-hidden="true"></i>
			        <input id="emailUsuarioActualizar" name="emailUsuarioActualizar" type="text" class="validate" data-length="100" maxlength="100" value=" ">
			        <label for="emailUsuarioActualizar">Correo:</label>
	        	</div>
	        	<div class="input-field col s6">
			        <i class="fa fa-key prefix" aria-hidden="true"></i>
			        <input id="passOneUsuarioActualizar" name="passOneUsuarioActualizar" type="password" class="validate" data-length="100" maxlength="100">
			        <label for="passOneUsuarioActualizar">Contraseña:</label>
	        	</div>
	        	<div class="input-field col s6">
			        <i class="fa fa-key prefix" aria-hidden="true"></i>
			        <input id="passTwoUsuarioActualizar" name="passTwoUsuarioActualizar" type="password" class="validate" data-length="100" maxlength="100">
			        <label for="passTwoUsuarioActualizar">Repita la Contraseña:</label>
	        	</div>
	        	<!-- <div class="file-field input-field col s12">
	        	  <div class="btn blue">
	        	    <span>Imagen</span>
	        	    <input type="file">
	        	  </div>
	        	  <div class="file-path-wrapper">
	        	    <input class="file-path validate" type="text">
	        	  </div>
	        	</div> -->
	      	</div>
	      </form>
	    </div>
	    <div class="modal-footer">
	      <a class="btn-floating btn-medium blue right tooltipped" data-position="bottom" data-delay="50" data-tooltip="Actualizar Registro" onclick="actualizarRegistro();"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
	    </div>
	  </div>
</body>
</html>
<?php } ?>