<?php

// Main Routes
$app->group('/', function(){

	$this->get('', function ($request, $response, $args) {

		if ($_SESSION == NULL) {
			header('refresh:.1; url=/../views/loginView.php');	
		}else{
			header('refresh:.1; url=/../views/menuView.php');	
		}

	})->setName('login');	

	$this->get('views/', function($request, $response, $args){
		
		if ($_SESSION == NULL) {
			return $response->withRedirect('/');
		}else{
			return $response->withRedirect('/cerrar');
		}

	});
	
	$this->get('objetivos', function ($request, $response, $args) {

		if ($_SESSION == NULL) {
			header('refresh:.1; url=/../views/loginView.php');	
		}else{
			header('refresh:.1; url=/../views/objetivoView.php');	
		}

	})->setName('objetivos');

	$this->get('usuarios', function ($request, $response, $args) {

		if ($_SESSION == NULL) {
			header('refresh:.1; url=/../views/loginView.php');	
		}else{
			header('refresh:.1; url=/../views/usuarioView.php');	
		}

	})->setName('usuarios');

	$this->get('cerrar', function ($request, $response, $args) {

		session_destroy();
	    unset($_SESSION);
	    header('refresh:.1; url=/../views/loginView.php');

	})->setName('cerrar_sesion');

});


/**
* Rutas para los usuarios
*/
$app->group('/api/usuarios', function(){

	/**
	* Listar a todos los usuarios
	*/
	$this->get('/', function ($request, $response, $args){

		$controller = new UsuarioController();
		$json = $controller->callAction('all');

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson($json, $code);

	})->setName('lista_usuarios');

	/**
	* Listar a todos los usuarios API
	*/
	$this->get('/android/list/', function ($request, $response, $args){

		$controller = new UsuarioController();
		$json = $controller->callAction('allAPI');

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson($json, $code);

	})->setName('lista_usuarios_android');

	/**
	* Insertar un usuario
	*/
	$this->post('/', function ($request, $response, $args){

		$post = $request->getParams();

		$controller = new UsuarioController();
		$json = $controller->callAction('add', $post);

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson($json, $code);

	})->setName('insertar_usuario');

	/**
	* Insertar un usuario
	*/
	$this->post('/android/', function ($request, $response, $args){

		$post = $request->getParams();

		$controller = new UsuarioController();
		$json = $controller->callAction('addAPI', $post);

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson(array($json), $code);

	})->setName('insertar_usuario_api');

	/**
	* Buscar un usuario por su ID
	*/
	$this->get('/{id}/', function ($request, $response, $args){

		$controller = new UsuarioController();
		$json = $controller->callAction('one', $args['id']);

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson($json, $code);

	})->setName('buscar_usuario_por_id');

	/**
	* Actualizar un usuario
	*/
	$this->post('/{id}/actualizar/', function ($request, $response, $args)
	{
		$id = $args['id'];
		$post = $request->getParams();
		$post['id'] = $id;

		$controller = new UsuarioController();
		$json = $controller->callAction('upd', $post);
		
		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson($json, $code);

	})->setName('actualizar_usuario');

	/**
	* Eliminar un usuario
	*/
	$this->post('/{id}/eliminar/', function ($request, $response, $args){

		$controller = new UsuarioController();
		$json = $controller->callAction('del', $args['id']);

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson($json, $code);

	})->setName('eliminar_usuario');

	/**
	* Autenticación de usuario
	*/
	$this->post('/auth/', function ($request, $response, $args) {

		$params = $request->getParams();
		$controller = new UsuarioController();
		$json = $controller->callAction('log', $params);

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson(array($json), $code);

	})->setName('autenticacion_usuario');

});


/**
* Rutas para los targets
*/
$app->group('/api/targets', function(){

	/**
	* Listar a todos los targets
	*/
	$this->get('/', function ($request, $response, $args){

		$controller = new TargetController();
		$json = $controller->callAction('all');

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson(array($json), $code);

	})->setName('lista_targets');

	/**
	* Insertar un objetivo
	*/
	$this->post('/', function ($request, $response, $args){

		$controller = new TargetController();
		$params = $request->getParams();
		$json = $controller->callAction('add', $params);

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson(array($json), $code);

	})->setName('insertar_targets');

	/**
	* Medir a distancia entre la posición actual y el objetivo más cercano
	*/
	$this->post('/medir/', function ($request, $response, $args){

		$controller = new TargetController();
		$params = $request->getParams();
		$json = $controller->callAction('cerca', $params);

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson(array($json), $code);

	})->setName('medir_distancia_target');

	/**
	* Buscar un objetivo por su ID
	*/
	$this->get('/{id}/', function ($request, $response, $args){

		$controller = new TargetController();
		$json = $controller->callAction('oneAPI', $args['id']);

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson($json, $code);

	})->setName('buscar_objetivo_por_id');

	/**
	* Buscar un objetivo por su QR_ID
	*/
	$this->post('/{id}/qrid/', function ($request, $response, $args){

		$controller = new TargetController();
		$json = $controller->callAction('oneAPIqr', $args['id']);

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson(array($json), $code);

	})->setName('buscar_objetivo_por_qrid');

	/**
	* Actualizar un objetivo
	*/
	$this->post('/{id}/actualizar/', function ($request, $response, $args)
	{
		$id = $args['id'];
		$post = $request->getParams();
		$post['id'] = $id;

		$controller = new TargetController();
		$json = $controller->callAction('uptAPI', $post);
		
		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson($json, $code);

	})->setName('actualizar_objetivo');

	/**
	* Eliminar un target
	*/
	$this->get('/{id}/eliminar/', function ($request, $response, $args){

		$controller = new TargetController();
		$json = $controller->callAction('del', $args['id']);

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson($json, $code);

	})->setName('eliminar_objetivo');

});