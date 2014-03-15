<?php
class listasMdl{
	public $bd_driver;
	
	function __construct(){
		//podrias aqui construir manejador bd
	}
	
	function alta($alumnos,$curso,$cicloEscolar){
		//Va ir a insertar a la base de datos
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
	
	function baja($lista){
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
	
	function consultar($lista){
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
	
	function modificar($alumnos,$curso,$cicloEscolar,$lista){
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
}
