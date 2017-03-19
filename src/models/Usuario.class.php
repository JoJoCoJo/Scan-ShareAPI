<?php

/**
* 
*/
use Illuminate\Database\Eloquent\Model as Model;

class Usuarios extends Model
{
	
	protected $table 		= 'users';
	protected $primaryKey 	= 'id';
	public $timestamps		= true;


}