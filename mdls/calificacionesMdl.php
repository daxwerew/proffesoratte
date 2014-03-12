<?php
class alumnosMdl{
	public $bd_driver;
	
	function __construct(){
		//podrias aqui construir manejador bd
	}
	
	function alta($nrc,$evaluacion,$alumnos){
		//Va ir a insertar a la base de datos
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
	
	function modificacion($nrc,$evaluacion,$alumnos){
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
	
	function consulta($nrc,$evaluacion){
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
}
