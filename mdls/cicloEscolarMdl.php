<?php
class alumnosMdl{
	public $bd_driver;
	
	function __construct(){
		//podrias aqui construir manejador bd
	}
	
	function alta($ciclo,$fechaInicio,$fechaFinal,$festivos){
		//Va ir a insertar a la base de datos
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
	
	function modificacion($ciclo,$fechaInicio,$fechaFinal,$festivos){
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
}
