<?php
class ControladorComun{
	public $modelo;
	function __construct(){
		$mdlNombre = substr(get_called_class(),0,-4).'Mdl';

		if( file_exists("mdls/{$mdlNombre}.php") ){
			require("mdls/{$mdlNombre}.php");
			$this->modelo = new $mdlNombre();
		}else{
			$error='No hay modelo';
			require('vistas/error.php');
		}
	}
}
