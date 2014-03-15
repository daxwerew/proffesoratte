<?php
class ControladorComun{
	public $modelo;
	function __construct(){
		$mdlNombre = substr(get_called_class(),0,-4).'Mdl';
		require("mdls/{$mdlNombre}.php");
		$this->modelo = new $mdlNombre();
	}
}
