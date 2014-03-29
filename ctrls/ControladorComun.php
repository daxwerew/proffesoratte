<?php
class ControladorComun{
	
	public $modelo;

	function __construct(){
		$mdlNombre = substr(get_class($this),0,-4).'Mdl';

		if( file_exists("mdls/{$mdlNombre}.php") ){
			require("mdls/{$mdlNombre}.php");
			$this->modelo = new $mdlNombre();
		}else{
			//$error="No hay modelo {$mdlNombre}.php";
			//require('vistas/error.php');
		}
	}




}
