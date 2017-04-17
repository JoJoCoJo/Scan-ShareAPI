<?php session_start(); 
	include '../parts/checar_sesion.php';
?>
<!DOCTYPE html>
<html>
<head>
	
	<link rel="stylesheet" type="text/css" href="/css/materialize.css">
	<link rel="stylesheet" type="text/css" href="/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="/sweetalert2/sweetalert2.css">
	<link rel="stylesheet" type="text/css" href="/DataTables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="/css/main.css">

	<title>Objetivos | Plataforma</title>

	<script type="text/javascript" src="/js/jquery-2.1.1.js"></script>
	<script type="text/javascript" src="/js/materialize.js"></script>
	<script type="text/javascript" src="/sweetalert2/sweetalert2.js"></script>
	<script type="text/javascript" src="/DataTables/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="/js/MeasureTool.js"></script>
	<script type="text/javascript" src="/js/qrcode.js"></script>

	<script type="text/javascript" src="/js/objetivos.js"></script>
</head>
<body class="banner">
	<header>
	<?php include '../parts/navbar.php'; ?>
	</header>
	<div class="container">
		<div class="row">
			<h1 class="center white-text">Objetivos</h1>
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
		    <h4>Registrar un nuevo Objetivo</h4>
		      <form class="col s12" id="formRegistroObjetivo" name="formRegistroObjetivo">
		      	<div class="row">
  					<div class="input-field col s12">
  				        <i class="fa fa-font prefix" aria-hidden="true"></i>
  				        <input id="nameObjetivo" name="nameObjetivo" type="text" class="validate" data-length="100" maxlength="100">
  				        <label for="nameObjetivo">Nombre:</label>
  		        	</div>
    	        	<div class="input-field col s4">
    			        <i class="fa fa-globe prefix" aria-hidden="true"></i>
    			        <input id="latitudeObjetivo" name="latitudeObjetivo" type="text" class="validate"  value="1.0" readonly>
    			        <label for="latitudeObjetivo" class="active">Latitud:</label>
    	        	</div>
    	        	<div class="input-field col s4">
    			        <i class="fa fa-globe prefix" aria-hidden="true"></i>
    			        <input id="longitudeObjetivo" name="longitudeObjetivo" type="text" class="validate" value="1.0"  readonly>
    			        <label for="longitudeObjetivo" class="active">Longitud:</label>
    	        	</div>
    	        	<div class="input-field col s4">
    			        <i class="fa fa-globe prefix" aria-hidden="true"></i>
    			        <input id="minmtsObjetivo" name="minmtsObjetivo" type="number" step="0.001" class="validate">
    			        <label for="minmtsObjetivo">Radio dentro del POI:</label>
    	        	</div>
      				<div class="col s12">
      					<div id="map">
      					</div>
      				</div>
		        	<div class="input-field col s12">
				        <i class="fa fa-keyboard-o prefix" aria-hidden="true"></i>
				        <textarea id="descriptionObjetivo" name="descriptionObjetivo" class="materialize-textarea" data-length="255" maxlength="255"></textarea>
				        <label for="descriptionObjetivo">Descripción:</label>
		        	</div>
		        	<div class="col s6">
		        		<label><strong>Tipo de objetivo:</strong></label>
				        <select id="typeObjetivo" name="typeObjetivo">
			              <option value="" disabled selected>Elija una opción...</option>
			              <option value="1">Código QR</option>
			              <option value="2">Localización GPS</option>
			            </select>
		        	</div>
		        	<div class="input-field col s6">
				        <i class="fa fa-phone prefix" aria-hidden="true"></i>
				        <input id="phoneObjetivo" name="phoneObjetivo" type="tel" class="validate" data-length="10" maxlength="10">
				        <label for="phoneObjetivo">Teléfono:</label>
		        	</div>
		        	<div class="input-field col s12">
				        <i class="fa fa-facebook-square prefix" aria-hidden="true"></i>
				        <input id="facebookObjetivo" name="facebookObjetivo" type="text" class="validate" data-length="50" maxlength="50">
				        <label for="facebookObjetivo">Facebook:</label>
		        	</div>
		        	<div class="input-field col s12">
				        <i class="fa fa-twitter-square prefix" aria-hidden="true"></i>
				        <input id="twitterObjetivo" name="twitterObjetivo" type="text" class="validate" data-length="50" maxlength="50">
				        <label for="twitterObjetivo">Twitter:</label>
		        	</div>
		        	<div class="input-field col s12">
				        <i class="fa fa-instagram prefix" aria-hidden="true"></i>
				        <input id="instagramObjetivo" name="instagramObjetivo" type="text" class="validate" data-length="100" maxlength="100">
				        <label for="instagramObjetivo">Instragram:</label>
		        	</div>
		        	<div class="input-field col s12">
				        <i class="fa fa-youtube prefix" aria-hidden="true"></i>
				        <input id="youtubeObjetivo" name="youtubeObjetivo" type="text" class="validate" data-length="100" maxlength="100">
				        <label for="youtubeObjetivo">YouTube:</label>
		        	</div>
		        	<div class="input-field col s12">
				        <i class="fa fa-laptop prefix" aria-hidden="true"></i>
				        <input id="urlObjetivo" name="urlObjetivo" type="text" class="validate" data-length="255" maxlength="255">
				        <label for="urlObjetivo">Página Web:</label>
		        	</div>
		      	</div>
		      </form>
		    </div>
		    <div class="modal-footer">
		      <a class="btn-floating btn-medium green right tooltipped" data-position="bottom" data-delay="50" data-tooltip="Guardar Registro" onclick="agregarObjetivo();"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
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
						                <th>Nombre</th>
						                <th>Descripción</th>
						                <th>Teléfono</th>
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
	    <h4>Actualizar Objetivo</h4>
	      <form class="col s12" id="formActualizarObjetivo" name="formRegistroObjetivo">
	      	<div class="row">
	      		<input id="idActualizarObjetivo" name="idActualizarObjetivo" type="text" class="validate" value="" 	hidden>	
				<div class="input-field col s12">
			        <i class="fa fa-font prefix" aria-hidden="true"></i>
			        <input id="nameActualizarObjetivo" name="nameActualizarObjetivo" type="text" class="validate" data-length="100" maxlength="100" value=" ">
			        <label for="nameActualizarObjetivo" class="active">Nombre:</label>
	        	</div>
	        	<div class="input-field col s4">
			        <i class="fa fa-globe prefix" aria-hidden="true"></i>
			        <input id="latitudeActualizarObjetivo" name="latitudeActualizarObjetivo" type="text" class="validate"  value="1.0" readonly>
			        <label for="latitudeActualizarObjetivo" class="active">Latitud:</label>
	        	</div>
	        	<div class="input-field col s4">
			        <i class="fa fa-globe prefix" aria-hidden="true"></i>
			        <input id="longitudeActualizarObjetivo" name="longitudeActualizarObjetivo" type="text" class="validate" value="1.0"  readonly>
			        <label for="longitudeActualizarObjetivo" class="active">Longitud:</label>
	        	</div>
	        	<div class="input-field col s4">
			        <i class="fa fa-globe prefix" aria-hidden="true"></i>
			        <input id="minmtsActualizarObjetivo" name="minmtsActualizarObjetivo" type="number" step="0.001" class="validate" value="1.0">
			        <label for="minmtsActualizarObjetivo" class="active">Radio dentro del POI:</label>
	        	</div>
  				<div class="col s12">
  					<div id="mapAct">
  					</div>
  				</div>
	        	<div class="input-field col s12">
			        <i class="fa fa-keyboard-o prefix" aria-hidden="true"></i>
			        <textarea id="descriptionActualizarObjetivo" name="descriptionActualizarObjetivo" class="materialize-textarea" data-length="255" maxlength="255"> </textarea>
			        <label for="descriptionActualizarObjetivo" class="active">Descripción:</label>
	        	</div>
	        	<div class="col s6">
	        		<label>Tipo de objetivo:</label>
			        <select id="typeActualizarObjetivo" name="typeActualizarObjetivo">
		              <option value="">Elija una opción...</option>
		              <option value="1">Código QR</option>
		              <option value="2">Localización GPS</option>
		            </select>
	        	</div>
	        	<div class="input-field col s6">
			        <i class="fa fa-phone prefix" aria-hidden="true"></i>
			        <input id="phoneActualizarObjetivo" name="phoneActualizarObjetivo" type="tel" class="validate" data-length="10" maxlength="10" value=" ">
			        <label for="phoneActualizarObjetivo" class="active">Teléfono:</label>
	        	</div>
	        	<div class="input-field col s12">
			        <i class="fa fa-facebook-square prefix" aria-hidden="true"></i>
			        <input id="facebookActualizarObjetivo" name="facebookActualizarObjetivo" type="text" class="validate" data-length="50" maxlength="50" value=" ">
			        <label for="facebookActualizarObjetivo" class="active">Facebook:</label>
	        	</div>
	        	<div class="input-field col s12">
			        <i class="fa fa-twitter-square prefix" aria-hidden="true"></i>
			        <input id="twitterActualizarObjetivo" name="twitterActualizarObjetivo" type="text" class="validate" data-length="50" maxlength="50" value=" ">
			        <label for="twitterActualizarObjetivo" class="active">Twitter:</label>
	        	</div>
	        	<div class="input-field col s12">
			        <i class="fa fa-instagram prefix" aria-hidden="true"></i>
			        <input id="instagramActualizarObjetivo" name="instagramActualizarObjetivo" type="text" class="validate" data-length="100" maxlength="100" value=" ">
			        <label for="instagramActualizarObjetivo" class="active">Instragram:</label>
	        	</div>
	        	<div class="input-field col s12">
			        <i class="fa fa-youtube prefix" aria-hidden="true"></i>
			        <input id="youtubeActualizarObjetivo" name="youtubeActualizarObjetivo" type="text" class="validate" data-length="100" maxlength="100" value=" ">
			        <label for="youtubeActualizarObjetivo" class="active">YouTube:</label>
	        	</div>
	        	<div class="input-field col s12">
			        <i class="fa fa-laptop prefix" aria-hidden="true"></i>
			        <input id="urlActualizarObjetivo" name="urlActualizarObjetivo" type="text" class="validate" data-length="255" maxlength="255" value=" ">
			        <label for="urlActualizarObjetivo" class="active">Página Web:</label>
	        	</div>
	      	</div>
	      </form>
	    </div>
	    <div class="modal-footer">
	      <a class="btn-floating btn-medium blue right tooltipped" data-position="bottom" data-delay="50" data-tooltip="Actualizar Registro" onclick="actualizarRegistro();"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
	    </div>
	  </div>
	  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUD9HMFiReCe-DjEP4VWsFsMKwEOJ3wio&callback&libraries=geometry&callback=initMap"></script>
</body>
</html>