<?php

/**
* 
*/
use Illuminate\Database\Capsule\Manager as DB;

class Connection
{
	public static function conecting ()	{

		$fileName = __DIR__ . '/../config/conf.db.ini';
		$config		=	parse_ini_file($fileName);
		$connection = new DB;
		$connection->addConnection($config);
		$connection->setAsGlobal();
		$connection->bootEloquent();
		return $connection;

	}

	public static function getConnection () {

		$fileName 	= __DIR__ . '/../config/conf.db.ini';
		$config		=	parse_ini_file( $fileName );
		$connection = new DB;
		$connection->addConnection( $config );
		$connection->setAsGlobal();
		$connection->bootEloquent();

		return $connection;			
	}

	public static function conectingAPI () {

		$fileNameAPI = __DIR__ . '/../config/conf2.db.ini';
		$configAPI		=	parse_ini_file($fileNameAPI);
		$connectionAPI = new DB;
		$connectionAPI->addConnection($configAPI);
		$connectionAPI->setAsGlobal();
		$connectionAPI->bootEloquent();
		return $connectionAPI;

	}

	public static function getConnectionAPI () {

		$fileNameAPI	= __DIR__ . '/../config/conf2.db.ini';
		$configAPI	=	parse_ini_file( $fileNameAPI );
		$connectionAPI = new DB;
		$connectionAPI->addConnection( $configAPI );
		$connectionAPI->setAsGlobal();
		$connectionAPI->bootEloquent();

		return $connectionAPI;

	}
}