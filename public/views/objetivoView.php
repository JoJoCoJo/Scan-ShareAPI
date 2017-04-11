<?php session_start(); 
	include '../parts/checar_sesion.php';
?>
<!DOCTYPE html>
<html>
<head>
	
	<link rel="stylesheet" type="text/css" href="/css/main.css">
	<link rel="stylesheet" type="text/css" href="/css/materialize.css">
	<link rel="stylesheet" type="text/css" href="/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="/sweetalert2/sweetalert2.css">
	<link rel="stylesheet" type="text/css" href="/DataTables/media/css/jquery.dataTables.css">

	<title>Objetivos | Plataforma</title>

	<script type="text/javascript" src="/js/jquery-2.1.1.js"></script>
	<script type="text/javascript" src="/js/materialize.js"></script>
	<script type="text/javascript" src="/sweetalert2/sweetalert2.js"></script>
	<script type="text/javascript" src="/DataTables/media/js/jquery.dataTables.js"></script>

	<script type="text/javascript" src="/js/objetivos.js"></script>
</head>
<body>
	<header>
	<?php include '../parts/navbar.php'; ?>
	</header>
	<div class="container">
		<div class="row">
			<h1 class="center">Objetivos</h1>
		</div>
		<div class="fixed-action-btn">
		  <a href="/" class="btn-floating btn-large green tooltipped" data-position="left" data-delay="50" data-tooltip="Agregar">
		    <i class="fa fa-plus" aria-hidden="true"></i>
		  </a>
		</div>
		<div class="row">
			<div class="col s12">
				<table id="dataTable" class="display striped" cellspacing="0" width="100%">
					<thead>
			            <tr>
			                <th>Nombre</th>
			                <th>Descripción</th>
			                <th>Teléfono</th>
			                <th>Acciones</th>
			            </tr>
			        </thead>
			        <tfoot>
			        	<tr>
			        	    <th>Nombre</th>
			        	    <th>Descripción</th>
			        	    <th>Teléfono</th>
			        	    <th>Acciones</th>
			        	</tr>
			        </tfoot>
				</table>
			</div>
		</div>
	</div>
</body>
</html>