<?php
class cursoMdl{
	public $bd_driver;
	
	function __construct(){
		//podrias aqui construir manejador bd
	}

	function alta($cicloEscolar,$nombre,$seccion,$academia,$nrc,$diasCurso_Horas){
		return true;
	}
	
	function consulta($seccion){
		return true;
	}
}
