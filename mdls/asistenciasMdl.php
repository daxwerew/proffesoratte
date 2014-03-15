<?php
class asistenciasMdl{
	public $bd_driver;
	
	function __construct(){
		//podrias aqui construir manejador bd
	}
	
	function alta($grupo,$alumnos,$fecha){
		//Va ir a insertar a la base de datos
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
	
	function modifica($grupo,$alumnos,$fecha){
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
	
	function consulta($grupo){
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
}
