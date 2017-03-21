<?php

/**
* 
*/
class UsuarioController extends Controller{

	static $routes = array(
		'all' 	 => 'obtenerUsuarios',
		'one' 	 => 'buscarUsuarioPorID',
		'add' 	 => 'insertarUsuario',
		'addAPI' => 'insertarUsuarioAPI',
		'upd'  	 => 'actualizarUsuario',
		'del' 	 => 'eliminarUsuario',
		'log' 	 => 'loginAppAndroid'
	);

	/**
	* 
	*/
	private $response = array(
		'code' 		=>	1,
		'data'		=>	array(),
		'message'	=>	''
	);

	private $attributes = array(
		'id', 
		'name', 
		'email', 
		'password', 
		'role_id'
	);

	/**
	* 
	*/
	public function __construct($app = null){
		$this->app = $app;
	}


	/**
	*
	*/
	public function obtenerUsuarios(){
		
		$usuarios = Usuarios::orderBy('name', 'ASC')->get();
		$this->response['data'] = $usuarios;
		$this->response['message'] = 'Lista Usuarios';

		return $this->response;
	}

	/**
	*
	*/
	public function buscarUsuarioPorID($id){

		$params = $this->limpiarDatos(array($id));

		if (is_int(intval($params[0]))) {

			$usuario = Usuarios::find(intval($params[0]));

			if ($usuario != null) {
				
				$this->response['code'] = 1;
				$this->response['data'] = $usuario;
				$this->response['message'] = 'Resgistro encontrado.';

			}else{

				$this->response['code'] = 4;
				$this->response['message'] = 'Resgistro no encontrado.';

			}

		}else{

			$this->response['code'] = 5;
			$this->response['message'] = 'El identificador del usuario debe ser de tipo numérico.';

		}

		return $this->response;
	}



	/**
	*
	*/
	public function insertarUsuario(Array $params){

		if (count($params) > 0 && $this->checarAtributos($params) === true){

			$params = $this->limpiarDatos($params);
			$messages = array();

			if (is_int(intval($params['id'])) == false){

				$messages[] = 'El campo ID debe ser de tipo numérico.';	
			}

			if (empty($params['email']) || is_null($params['email']) || strlen($params['email']) == 0){

				$messages[] = 'El campo nombre no debe estar vacío.';

			}elseif (count(Usuarios::where('email', '=', $params['email'])->get()) > 0) {

				$messages[] = 'Ya existe una respuesta con el nombre: \'' . $params['email'] . '\'';

			}

			if (empty($params['name']) || is_null($params['name']) || strlen($params['name']) == 0){

				$messages[] = 'El campo nombre no debe estar vacío.';

			}

			if (empty($params['password']) || is_null($params['password']) || strlen($params['password']) == 0){

				$messages[] = 'El campo nombre no debe estar vacío.';

			}

			if (is_int(intval($params['role_id'])) == false){

				$messages[] = 'El campo rol debe ser de tipo numérico.';	
			}

			if (count($messages) > 0){

				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;

			}else{

				$db = Connection::getConnection();
				$db::beginTransaction();

				try {

					$salt = '$2y$12$' . substr(strtr(base64_encode(openssl_random_pseudo_bytes(22)), '+', '.'), 0, 22);

					$usuario 		= new Usuarios();
					$usuario->id 	= intval($params['id']);
					$usuario->name 	= $params['name'];
					$usuario->email = $params['email'];			
					$usuario->password = crypt($params['password'], $salt);
					$usuario->role_id = $params['role_id'];

					if ($usuario->save()){

						$db::commit();
						$this->response['code'] = 1;
						$this->response['data'] = $usuario;
						$this->response['message'] = 'Se ha guardado correctamente los datos.';

					}else{

						$this->response['code'] = 5;
						$this->response['message'] = 'No se pudo completar la acción, intentelo más tarde.';

					}
					
				} catch (Exception $e) {

					$db::rollBack();
					$this->response['code'] = 5;
					$this->response['message'] = 'Ocurrió un error, favor de contactar al administrador.';
					$this->response['error'] = $e->getMessage();

				}


			}


		}else{

			$this->response['code'] = 2;
			$this->response['data'] = $params;
			$this->response['message'] = 'Todos los parámetros son requeridos.';

		}

		return $this->response;
	}

		/**
	*
	*/
	public function insertarUsuarioAPI(Array $params){
		
		$db = Connection::getConnectionAPI();

		if (count($params) > 0 && $this->checarAtributos($params) === true){

			$params = $this->limpiarDatos($params);
			$messages = array();

			if (is_int(intval($params['id'])) == false){

				$messages[] = 'El campo ID debe ser de tipo numérico.';	
			}

			if (empty($params['email']) || is_null($params['email']) || strlen($params['email']) == 0){

				$messages[] = 'El campo nombre no debe estar vacío.';

			}elseif (count(Usuarios::where('email', '=', $params['email'])->get()) > 0) {

				$messages[] = 'Ya existe una respuesta con el nombre: \'' . $params['email'] . '\'';

			}

			if (empty($params['name']) || is_null($params['name']) || strlen($params['name']) == 0){

				$messages[] = 'El campo nombre no debe estar vacío.';

			}

			if (empty($params['password']) || is_null($params['password']) || strlen($params['password']) == 0){

				$messages[] = 'El campo nombre no debe estar vacío.';

			}

			if (is_int(intval($params['role_id'])) == false){

				$messages[] = 'El campo rol debe ser de tipo numérico.';	
			}

			if (count($messages) > 0){

				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;

			}else{

				
				$db::beginTransaction();

				try {

					$salt = '$2y$12$' . substr(strtr(base64_encode(openssl_random_pseudo_bytes(22)), '+', '.'), 0, 22);

					$usuario 		= new Usuarios();
					$usuario->id 	= intval($params['id']);
					$usuario->name 	= $params['name'];
					$usuario->email = $params['email'];
					$usuario->password = crypt($params['password'], $salt);
					$usuario->salt 	= $salt;
					$usuario->role_id = $params['role_id'];

					if ($usuario->save()){

						$db::commit();
						$this->response['code'] = 1;
						$this->response['data'] = $usuario;
						$this->response['message'] = 'Se ha guardado correctamente los datos.';

					}else{

						$this->response['code'] = 5;
						$this->response['message'] = 'No se pudo completar la acción, intentelo más tarde.';

					}
					
				} catch (Exception $e) {

					$db::rollBack();
					$this->response['code'] = 5;
					$this->response['message'] = 'Ocurrió un error, favor de contactar al administrador.';
					$this->response['error'] = $e->getMessage();

				}


			}


		}else{

			$this->response['code'] = 2;
			$this->response['data'] = $params;
			$this->response['message'] = 'Todos los parámetros son requeridos.';

		}

		return $this->response;
	}

	/**
	+
	*/
	public function actualizarUsuario(Array $params){

		if (count($params) > 0 && $this->checarAtributos($params) === true){

			$params = $this->limpiarDatos($params);
			$messages = array();

			if (Usuarios::find($params['id']) == null)
			{
				$messages[] = 'No existe el usuario.';
			}

			if (is_int(intval($params['id'])) == false){

				$messages[] = 'El campo ID debe ser de tipo numérico.';	
			}

			if (empty($params['email']) || is_null($params['email']) || strlen($params['email']) == 0){

				$messages[] = 'El campo nombre no debe estar vacío.';

			}elseif (count(Usuarios::where('email', '=', $params['email'])->get()) > 0) {

				$messages[] = 'Ya existe una respuesta con el nombre: \'' . $params['email'] . '\'';

			}

			if (empty($params['name']) || is_null($params['name']) || strlen($params['name']) == 0){

				$messages[] = 'El campo nombre no debe estar vacío.';

			}

			if (empty($params['password']) || is_null($params['password']) || strlen($params['password']) == 0){

				$messages[] = 'El campo nombre no debe estar vacío.';

			}

			if (is_int(intval($params['role_id'])) == false){

				$messages[] = 'El campo rol debe ser de tipo numérico.';	
			}

			if (count($messages) > 0){

				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;

			}else{

				$db = Connection::getConnection();
				$db::beginTransaction();

				try {

					$salt = '$2y$12$' . substr(strtr(base64_encode(openssl_random_pseudo_bytes(22)), '+', '.'), 0, 22);

					$usuario 		= Usuarios::find($params['id']);
					$usuario->id 	= intval($params['id']);
					$usuario->name 	= $params['name'];
					$usuario->email = $params['email'];					
					$usuario->password = crypt($params['password'], $salt);
					$usuario->role_id = $params['role_id'];

					if ($usuario->save()){

						$db::commit();
						$this->response['code'] = 1;
						$this->response['data'] = $usuario;
						$this->response['message'] = 'Se han actualizado correctamente los datos.';

					}else{

						$this->response['code'] = 5;
						$this->response['message'] = 'No se pudo completar la acción, intentelo más tarde.';

					}
					
				} catch (Exception $e) {

					$db::rollBack();
					$this->response['code'] = 5;
					$this->response['message'] = 'Ocurrió un error, favor de contactar al administrador.';
					$this->response['error'] = $e->getMessage();

				}


			}


		}else{

			$this->response['code'] = 2;
			$this->response['data'] = $params;
			$this->response['message'] = 'Todos los parámetros son requeridos.';

		}


		return $this->response;
	}
	
	/**
	*
	*/
	public function eliminarUsuario($id){

		$params = $this->limpiarDatos(array($id));
		$usuario = Usuarios::find($params[0]);

		if (count($usuario) > 0) {
			
			$db = Connection::getConnection();
			$db::beginTransaction();

			try {

				if ($usuario->delete()) {

					$db::commit();
					$this->response['code'] = 1;
					$this->response['message'] = 'El Registro se ha eliminado correctamente.';

				}
				
			} catch (Exception $e) {
				
				$db::rollBack();
				$this->response['code'] = 5;
				$this->response['message'] = 'Ocurrió un error, favor de contactar al administrado.';
				$this->response['error'] = $e->getMessage();

			}

		}else{

			$this->response['code'] = 4;
			$this->response['message'] = 'Registro no encontrado.';

		}

		return $this->response;
	}

	/**
	*
	*/
	public function loginAppAndroid(Array $params) {

		$db = Connection::getConnectionAPI();

		if ((!array_key_exists('email', $params) || !array_key_exists('password', $params))) {
				
				$this->response['code'] = 2;
				$this->response['message'] = 'Todos los parámetros son requeridos';

			} else {

				$params = $this->limpiarDatos($params);
				$messages = array();

				if (strlen($params['email']) == 0 || strlen($params['email']) > 255 || empty($params['email'])){

					$messages[] = 'El campo email no puede quedar vacío ni tener una longitud mayor a 255 caracteres';

				}elseif(!filter_var($params['email'], FILTER_VALIDATE_EMAIL)){

					$messages[] = 'El email no es valido';
				}

				if (strlen($params['password']) == 0 || empty($params['password'])){

					$messages[] = 'El campo contraseña no puede quedar vacío';
				}

				if (count($messages) > 0){

					$this->response['code'] = 2;
					$this->response['data'] = $params;
					$this->response['message'] = $messages;

				}else{

					try {
						
						$usuario = Usuarios::where('email', '=', $params['email'])->get();
						
						if (count($usuario) > 0) {

							$salt = $usuario[0]->salt;
							$password = crypt($params['password'], $salt);

							if ($usuario[0]->password === $password) {
								
								$datosUsuario = new Usuarios();
								$datosUsuario->name 	= $usuario[0]->name;
								$datosUsuario->email 	= $usuario[0]->email;
								$datosUsuario->role_id 	= $usuario[0]->role_id;

								$this->response['code'] = 1;
								$this->response['data'] = $datosUsuario->toArray();
								$this->response['message'] = 'Autenticación correcta';

							}else{

								$this->response['code'] = 2;
								$this->response['data'] = $params;
								$this->response['message'] = 'Contraseña incorrecta';
							}

						}else{

							$this->response['code'] = 4;
							$this->response['data'] = $params;
							$this->response['message'] = 'Usuario no encontrado';

						}

					} catch (Exception $e) {
						
						$this->response['code'] = 5;
						$this->response['message'] = 'Ocurrió un error, favor de contactar al administrador.';
						$this->response['error'] = $e->getMessage();
						
					}
				}
			}

		$json = $this->response;
		return $json;
	}

	/**
	* 
	*/
	private function limpiarDatos(Array $params){

		if (count($params) > 0){

			foreach ($params as $key => $value) {
				$value = strip_tags($value);
				$value = filter_var($value, FILTER_SANITIZE_STRING);
				$value = htmlspecialchars($value);

				if (is_int($value)) {

					$value = filter_var($value, FILTER_SANITIZE_NUMBER_INT); 
					$value = filter_id($value, FILTER_VALIDATE_INT);
				}

				$params[$key] = $value;
			}
		}

		return $params;
	}


	/**
	* 
	*/
	private function checarAtributos(Array $params){

		$continuar = true;

		foreach ($this->attributes as $key => $attribute) {
		
			if (!array_key_exists($attribute, $params)) { 
				$continuar = false;
				break;
			}
		}

		return $continuar;
	}
}