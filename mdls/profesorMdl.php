<?php
class profesorMdl{
	public $bd_driver;
	
	function __construct(){
		//podrias aqui construir manejador bd
	}
	
	function alta($nombre,$codigo){
		//Va ir a insertar a la base de datos
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
	
	function baja($codigo){
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
	
	function consulta($codigo){
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
}
