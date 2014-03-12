<?php
class grupoMdl{
	public $bd_driver;
	
	function __construct(){
		//podrias aqui construir manejador bd
	}

	function alta($nombre,$nrc,$seccion){
		return true;
	}
	
	function listaEstudiantes($seccion, $ordenamineto=''){
		$alumnos = array('Abelardo','Bernardo','Cesar','Diego','Eduardo','Aaron');
		switch ( strtoupper($ordenamineto) ) {
			case 'ASC':
				sort($alumnos);
				break;
			case 'DESC':
				rsort($alumnos);
				break;
			case 'RAND':
				shuffle($alumnos);
				break;
		}
		//Regresa lista de alumnos
		return $alumnos;
	}
}
