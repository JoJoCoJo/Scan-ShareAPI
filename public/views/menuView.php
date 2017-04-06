<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="/css/main.css">
	<link rel="stylesheet" type="text/css" href="/css/materialize.css">
	<link rel="stylesheet" type="text/css" href="/font-awesome-4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="/sweetalert2/sweetalert2.css">

	<title>¡Bienvenido!</title>

	<script type="text/javascript" src="/js/jquery-3.2.0.js"></script>
	<script type="text/javascript" src="/js/materialize.js"></script>
	<script type="text/javascript" src="/sweetalert2/sweetalert2.js"></script>

	<script type="text/javascript">
		var nombre = sessionStorage.getItem('loginNombre');
		var apellido = sessionStorage.getItem('loginApellido');
		var email = sessionStorage.getItem('loginEmail');
		var nacimiento = sessionStorage.getItem('loginBirth');
		var role = sessionStorage.getItem('loginRole');

		$(document).ready(function(){
			document.getElementById('nombreMenu').text = nombre +' '+ apellido;
			document.getElementById('emailMenu').text = email +',  '+ nacimiento+', '+ role;
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			  $(".button-collapse").sideNav();
		});
	</script>
</head>
<body>
<header>
	<nav class="blue darken-4">		
		<ul id="slide-out" class="side-nav">
			<li>
				<div class="userView">
			      <div class="background">
			        <img src="/media/image/fondo-banner.jpg" width="100%">
			      </div>
			      <a href="#!user"><img class="circle" src="/media/image/user.png"></a>
			      <a href="#!name" id="nombreMenu" name="nombreMenu"><span class="white-text name">Example Name</span></a>
			      <a href="#!email" id="emailMenu" name="emailMenu"><span class="white-text email">example@gmail.com</span></a>
			    </div>
			</li>
		    <li><a href="#!">First Sidebar Link</a></li>
		    <li><a href="#!">Second Sidebar Link</a></li>
	    </ul>
	    <a href="#" data-activates="slide-out" class="button-collapse show-on-large"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></a>		      
	</nav>
</header>

<h1>PASASTE LA PRUEBA :v</h1>
</body>
</html>