<?php
// Routes


$app->get('/', function ($request, $response, $args) {

	header('refresh:.1; url=/../views/loginView.php');

});

$app->get('/api', function ($request, $response, $args) {

    echo "¿qué onda ese?";

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
	$this->post('/', function ($request, $response, $args){

		$controller = new TargetController();
		$json = $controller->callAction('all');

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson(array($json), $code);

	})->setName('lista_targets');

	/**
	* Medir a distancia entre la posición actual y el target más cercano
	*/
	$this->post('/medir/', function ($request, $response, $args){

		$controller = new TargetController();
		$params = $request->getParams();
		$json = $controller->callAction('cerca', $params);

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson(array($json), $code);

	})->setName('medir_distancia_target');

});