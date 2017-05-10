<?php

/**
* 
*/
class TargetController extends Controller
{
	
	static $routes = array(
		'all' 	 	=> 'obtenerTargets',
		'cerca' 	=> 'medirDistancia',
		'add'		=> 'insertarTargetAPI',
		'oneAPI'	=> 'buscarTargetPorIdAPI',
		'oneAPIqr'	=> 'buscarTargetPorIdAPIqr',
		'del' 	 	=> 'eliminarObjetivo',
		'uptAPI'	=> 'actualizarTargetAPI'
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
		'name',
		'description',
		'email',
		'phone',
		'facebook',
		'twitter',
		'instagram',
		'youtube',
		'type',
		'url'		
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
	public function obtenerTargets(){

		$db = Connection::getConnectionAPI();

		$targets = Targets::orderBy('id', 'ASC')->get();
		$this->response['data'] = $targets;
		$this->response['message'] = 'Lista Targets';

		return $this->response;
	}

	/**
	*
	*/
	public function medirDistancia(Array $params){

		$db = Connection::getConnectionAPI();

		$params = $this->limpiarDatos($params);

		if (count($params) == 0 || !array_key_exists('latitude', $params) || !array_key_exists('longitude', $params)) {

			$this->response['code'] = 2;
			$this->response['data'] = $params;
			$this->response['message'] = 'Todos los parámetros son requeridos';
			
		}else{
			$messages = array();
			$params['latitude'] = doubleval($params['latitude']);
			$params['longitude'] = doubleval($params['longitude']);

			if (empty($params['latitude']) || empty($params['longitude'])) {

				$messages[] = 'El campo latitude o longitude no pueden quedar vacíos.';

			}elseif (!is_double($params['latitude']) || !is_double($params['longitude'])) {
				
				$messages[] = 'El campo latitude o longitude tienen que ser números decimales.';

			}

			if (count($messages) > 0) {

				$this->response['code'] = 3;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;

			}else{

				$lat = $params['latitude'];
				$lon = $params['longitude'];

				$targets = Targets::select($db::raw('*, (6371 * ACOS(SIN(RADIANS(latitude)) * SIN(RADIANS('.$lat.')) + COS(RADIANS(longitude - '.$lon.')) * COS(RADIANS(latitude)) * COS(RADIANS('.$lat.')))) AS distance'))->orderBy("distance", "ASC")->limit(1)->get();
				
				$minimaDistancia = doubleval($targets[0]->min_mts);
				$resultadoDistancia = $targets[0]->distance;

				if ($minimaDistancia >= $resultadoDistancia) {
					
					unset($targets[0]->id);
					unset($targets[0]->min_mts);
					unset($targets[0]->updated_at);
					unset($targets[0]->created_at);
					unset($targets[0]->type);
					unset($targets[0]->shared);
					$this->response['data'] = $targets;
					$this->response['message'] = 'DENTRO DEL POI: Distancia entre punto actual y el Target más cercano';

				}else{

					unset($targets[0]->id);
					unset($targets[0]->min_mts);
					unset($targets[0]->updated_at);
					unset($targets[0]->created_at);
					unset($targets[0]->type);
					unset($targets[0]->shared);
					$this->response['code'] = 4;
					$this->response['data'] = $targets;
					$this->response['message'] = 'FUERA DEL POI: Distancia entre punto actual y el Target más cercano';

				}

			}

		}


		return $this->response;
	}

	/**
	*
	*/
	public function buscarTargetPorIdAPI($id){

		$db = Connection::getConnectionAPI();

		$params = $this->limpiarDatos(array($id));

		if (is_int(intval($params[0]))) {

			$target = Targets::find(intval($params[0]));

			if ($target != null) {
				
				$this->response['code'] = 1;
				$this->response['data'] = $target;
				$this->response['message'] = 'Resgistro encontrado.';

			}else{

				$this->response['code'] = 4;
				$this->response['message'] = 'Resgistro no encontrado.';

			}

		}else{

			$this->response['code'] = 5;
			$this->response['message'] = 'El identificador del Objetivo debe ser de tipo numérico.';

		}

		return $this->response;
	}

	/**
	*
	*/
	public function buscarTargetPorIdAPIqr($id){

		$db = Connection::getConnectionAPI();

		$params = $this->limpiarDatos(array($id));

		$target = Targets::where('qr_id', '=', $params[0])->get();
		
		if (count($target) > 0) {
			
			unset($target[0]->id);
			unset($target[0]->qr_id);
			unset($target[0]->updated_at);
			unset($target[0]->created_at);

			$this->response['code'] = 1;
			$this->response['data'] = $target;
			$this->response['message'] = 'Resgistro encontrado.';

		}else{

			$this->response['code'] = 4;
			$this->response['data'] = $params;
			$this->response['message'] = 'Resgistro no encontrado.';

		}


		return $this->response;
	}

	/**
	*
	*/
	public function insertarTargetAPI(Array $params){
		
		$db = Connection::getConnectionAPI();

		if (count($params) > 0 && $this->checarAtributos($params) === true){

			$params = $this->limpiarDatos($params);

			$params['latitude'] = doubleval($params['latitude']);
			$params['longitude'] = doubleval($params['longitude']);
			$params['min_mts'] = doubleval($params['min_mts']);

			$messages = array();
			
			if (empty($params['name']) || is_null($params['name']) || strlen($params['name']) == 0){

				$messages[] = 'El campo Nombre no debe estar vacío, ni tener más de 100 carácteres';

			}

			if (empty($params['description']) || is_null($params['description']) || strlen($params['description']) == 0){

				$messages[] = 'El campo Descripción no debe estar vacío, ni tener más de 255 carácteres';

			}

			if (strlen($params['email']) == 0 || strlen($params['email']) > 255 || empty($params['email'])){

				$messages[] = 'El campo email no puede quedar vacío ni tener una longitud mayor a 255 caracteres';

			}elseif(!filter_var($params['email'], FILTER_VALIDATE_EMAIL)){

				$messages[] = 'El email no es valido';
			}

			if (empty($params['phone']) || is_null($params['phone']) || !is_numeric($params['phone'])){

				$messages[] = 'El campo Teléfono debe ser de tipo numérico.';
			}

			if (empty($params['latitude']) || empty($params['longitude'])) {

				$messages[] = 'El campo latitude o longitud no pueden quedar vacíos.';

			}elseif (!is_double($params['latitude']) || !is_double($params['longitude'])) {
				
				$messages[] = 'El campo latitude o longitud deben ser números decimales.';

			}

			if (empty($params['min_mts']) || !is_double($params['min_mts'])) {

				$messages[] = 'El campo de Radio dentro del POI no puede quedar vacío y debe ser número decimal.';

			}
			
			if (empty($params['facebook']) || is_null($params['facebook']) || strlen($params['facebook']) == 0){

				$messages[] = 'El campo Facebook no debe estar vacío, ni tener más de 100 carácteres';

			}

			if (empty($params['twitter']) || is_null($params['twitter']) || strlen($params['twitter']) == 0){

				$messages[] = 'El campo Twitter no debe estar vacío, ni tener más de 100 carácteres';

			}

			if (empty($params['instagram']) || is_null($params['instagram']) || strlen($params['instagram']) == 0){

				$messages[] = 'El campo Instagram no debe estar vacío, ni tener más de 100 carácteres';

			}

			if (empty($params['youtube']) || is_null($params['youtube']) || strlen($params['youtube']) == 0){

				$messages[] = 'El campo Youtube no debe estar vacío, ni tener más de 100 carácteres';

			}

			if (empty($params['url']) || is_null($params['url']) || strlen($params['url']) == 0){

				$messages[] = 'El campo Página Web no debe estar vacío, ni tener más de 255 carácteres';

			}

			if (empty($params['type']) || is_null($params['type']) || is_int($params['type'])){

				$messages[] = 'Debe seleccionar un Tipo de objetivo';
			}

			if (count($messages) > 0){

				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;

			}else{

				
				$db::beginTransaction();

				try {

					$target 				= new Targets();
					$target->id 			= null;
					$target->name 			= $params['name'];
					$target->qr_id			= uniqid('', true);
					$target->description 	= $params['description'];
					$target->phone			= $params['phone'];
					$target->latitude		= $params['latitude'];
					$target->longitude		= $params['longitude'];
					$target->min_mts		= $params['min_mts'];
					$target->facebook		= $params['facebook'];
					$target->twitter		= $params['twitter'];
					$target->instagram		= $params['instagram'];
					$target->youtube		= $params['youtube'];
					$target->url			= $params['url'];
					$target->type			= $params['type'];


					if ($target->save()){

						$db::commit();
						$this->response['code'] = 1;
						$this->response['data'] = $target;
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
	public function eliminarObjetivo($id){

		$db = Connection::getConnectionAPI();

		$params = $this->limpiarDatos(array($id));
		$objetivo = Targets::find($params[0]);
		
		if (count($objetivo) > 0) {
			
			
			$db::beginTransaction();

			try {

				if ($objetivo->delete()) {

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
	+
	*/
	public function actualizarTargetAPI(Array $params){

		$db = Connection::getConnectionAPI();

		if (count($params) > 0 && $this->checarAtributos($params) === true){

			$params = $this->limpiarDatos($params);

			$params['latitude'] = doubleval($params['latitude']);
			$params['longitude'] = doubleval($params['longitude']);
			$params['min_mts'] = doubleval($params['min_mts']);

			$messages = array();

			if (Targets::find($params['id']) == null){
				
				$messages[] = 'No existe el Objetivo.';
			}

			if (is_numeric(intval($params['id'])) == false){

				$messages[] = 'El campo ID debe ser de tipo numérico. consulte al administrador';
			}
			
			if (empty($params['name']) || is_null($params['name']) || strlen($params['name']) == 0){

				$messages[] = 'El campo Nombre no debe estar vacío, ni tener más de 100 carácteres';

			}

			if (empty($params['description']) || is_null($params['description']) || strlen($params['description']) == 0){

				$messages[] = 'El campo Descripción no debe estar vacío, ni tener más de 255 carácteres';

			}

			if (strlen($params['email']) == 0 || strlen($params['email']) > 255 || empty($params['email'])){

				$messages[] = 'El campo email no puede quedar vacío ni tener una longitud mayor a 255 caracteres';

			}elseif(!filter_var($params['email'], FILTER_VALIDATE_EMAIL)){

				$messages[] = 'El email no es valido';
			}

			if (empty($params['phone']) || is_null($params['phone']) || !is_numeric($params['phone'])){

				$messages[] = 'El campo Teléfono debe ser de tipo numérico.';
			}

			if (empty($params['latitude']) || empty($params['longitude'])) {

				$messages[] = 'El campo latitude o longitud no pueden quedar vacíos.';

			}elseif (!is_double($params['latitude']) || !is_double($params['longitude'])) {
				
				$messages[] = 'El campo latitude o longitud deben ser números decimales.';

			}

			if (empty($params['min_mts']) || !is_double($params['min_mts'])) {

				$messages[] = 'El campo de Radio dentro del POI no puede quedar vacío y debe ser número decimal.';

			}
			
			if (empty($params['facebook']) || is_null($params['facebook']) || strlen($params['facebook']) == 0){

				$messages[] = 'El campo Facebook no debe estar vacío, ni tener más de 100 carácteres';

			}

			if (empty($params['twitter']) || is_null($params['twitter']) || strlen($params['twitter']) == 0){

				$messages[] = 'El campo Twitter no debe estar vacío, ni tener más de 100 carácteres';

			}

			if (empty($params['instagram']) || is_null($params['instagram']) || strlen($params['instagram']) == 0){

				$messages[] = 'El campo Instagram no debe estar vacío, ni tener más de 100 carácteres';

			}

			if (empty($params['youtube']) || is_null($params['youtube']) || strlen($params['youtube']) == 0){

				$messages[] = 'El campo Youtube no debe estar vacío, ni tener más de 100 carácteres';

			}

			if (empty($params['url']) || is_null($params['url']) || strlen($params['url']) == 0){

				$messages[] = 'El campo Página Web no debe estar vacío, ni tener más de 255 carácteres';

			}

			if (empty($params['type']) || is_null($params['type']) || !is_numeric($params['type'])){

				$messages[] = 'Debe seleccionar un Tipo de objetivo';
			}

			

			if (count($messages) > 0){

				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;

			}else{

				$db::beginTransaction();

				try {


					$target 				= Targets::find($params['id']);
					$target->id 			= intval($params['id']);
					$target->name 			= $params['name'];
					$target->description 	= $params['description'];
					$target->phone			= $params['phone'];
					$target->latitude		= $params['latitude'];
					$target->longitude		= $params['longitude'];
					$target->min_mts		= $params['min_mts'];
					$target->facebook		= $params['facebook'];
					$target->twitter		= $params['twitter'];
					$target->instagram		= $params['instagram'];
					$target->youtube		= $params['youtube'];
					$target->url			= $params['url'];
					$target->type			= $params['type'];


					if ($target->save()){

						$db::commit();
						$this->response['code'] = 1;
						$this->response['data'] = $target;
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