<?php 

	@$nombreCompletoUsuario 	= $_SESSION['sesionLogin']['name'];
	@$nivelUsuario		   		= $_SESSION['sesionLogin']['role'];

	if (isset($_SESSION['sesionLogin']) == FALSE) {

		session_destroy();
		$_SESSION = array();
		unset($_SESSION);

		echo "<html><meta charset=\"utf-8\"><script>alert ('Por favor inicie sesión');</script><body style=\"display:none\"></body></html>";
		header('refresh:.1; url=/../views/loginView.php');

	}else{

	    $horaEntrada  	= $_SESSION['sesionLogin']['horaEntrada']; 
	    $horaActual	  	= time(); 
	    $tiempoSesion 	= $horaActual - $horaEntrada;

	    if($tiempoSesion > 1800) { 
	     
		    session_destroy();
		    $_SESSION = array();
		    unset($_SESSION);
		    
		    echo "<html><meta charset=\"utf-8\"><script>alert ('La sesión estuvo inactiva por más de 30 mins,\\nPor favor de inicie sesión de nuevo')</script><body style=\"display:none\"></body></html>";
		    header('refresh:.1; url=/../views/loginView.php');

	    }else {
	    	
	    	date_default_timezone_set('America/Mexico_City');
	    	$_SESSION['sesionLogin']['horaFormat'] = date('g:i a');
	    	$_SESSION['sesionLogin']['horaEntrada'] = $horaActual;

	    }
	}


?>