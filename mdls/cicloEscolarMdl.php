<?php
class cicloEscolarMdl{
	public $bd_driver;
	
	function __construct(){
		//podrias aqui construir manejador bd
	}
	
	function alta($ciclo,$fechasCiclo){
		//Va ir a insertar a la base de datos
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
	
	function modificar($ciclo,$festivos){
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
	
	function baja($ciclo){
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
	
	function consulta($ciclo){
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
}
