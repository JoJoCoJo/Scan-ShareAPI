<div class="navbar-fixed">
	<nav class="blue">
		<div class="nav-wrapper">
			<a href="#" class="brand-logo center"><img class="responsive-img" src="/media/image/logo_scanshare.png" width="65px" /></a>
				
			<a href="#" data-activates="slide-out" class="button-collapse show-on-large"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></a>
	    </div>
	</nav>
</div>
<ul id="slide-out" class="side-nav">
	<li>
		<div class="userView">
	      <div class="background">
	        <img src="/media/image/fondo-banner.jpg" width="100%">
	      </div>
	      <a href="#!user"><img class="circle" src="/media/image/user.jpg"></a>
	      <a href="#!name" ><span class="white-text name"><?php echo $_SESSION['sesionLogin']['name'] .' '. $_SESSION['sesionLogin']['lastname']; ?></span></a>
	      <a href="#!email" ><span class="white-text email"><?php echo $_SESSION['sesionLogin']['email']; ?> <br />Inicio Sesión: <?php echo $_SESSION['sesionLogin']['horaFormat']; ?></span></a>
	    </div>
	</li>
	<li><a href="/"><i class="fa fa-home" aria-hidden="true"></i>Inicio</a></li>				

	<?php if ($_SESSION['sesionLogin']['role'] === 1) { ?>

    <li><a href="/usuarios"><i class="fa fa-id-card-o" aria-hidden="true"></i>Usuarios</a></li>
    <li><a href="/objetivos"><i class="fa fa-bullseye" aria-hidden="true"></i>Objetivos</a></li>
    
	<?php }elseif ($_SESSION['sesionLogin']['role'] === 2) { ?>

    <li><a href="/objetivos"><i class="fa fa-bullseye" aria-hidden="true"></i>Objetivos</a></li>

   <?php } ?>

   <li><a href="/cerrar"><i class="fa fa-sign-out" aria-hidden="true"></i>Salir</a></li>
</ul>