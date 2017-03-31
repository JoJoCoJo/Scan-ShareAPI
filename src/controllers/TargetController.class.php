<?php

/**
* 
*/
class TargetController extends Controller
{
	
	static $routes = array(
		'all' 	 	=> 'obtenerTargets',
		'cerca' 	=> 'medirDistancia'
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
		'description',
		'phone',
		'latitude',
		'longitude',
		'facebook',
		'twitter',
		'instagram',
		'youtube',
		'type',
		'shared',
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

				$messages[] = 'El campo latitude o longitude no puede quedar vacío y deben ser números decimales';

			}elseif (!is_double($params['latitude']) || !is_double($params['longitude'])) {
				
				$messages[] = 'El campo latitude o longitude tienen que ser números decimales';

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