<?php
// Routes


$app->get('/api', function ($request, $response, $args) {

    echo "¿qué onda ese?";
});


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
	* Buscar un usuario por su ID
	*/
	$this->get('/{id}/', function ($request, $response, $args){

		$controller = new UsuarioController();
		$json = $controller->callAction('one', $args['id']);

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson($json, $code);

	})->setName('buscar_usuario_por_id');

	/**
	* 
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
	* 
	*/
	$this->post('/{id}/eliminar/', function ($request, $response, $args){

		$controller = new UsuarioController();
		$json = $controller->callAction('del', $args['id']);

		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson($json, $code);

	})->setName('eliminar_usuario');

});