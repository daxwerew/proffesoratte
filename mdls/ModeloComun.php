<?php
class ModeloComun{
	public $mysqli;

	function __construct(){

		require('db.inc.php');
		
		$this->mysqli = new mysqli($db_site, $db_user, $db_pass, $db_schema);
		if ( $this->mysqli->connect_error) {
		    die('Error de Conexión (' . $this->mysqli->connect_errno . ') '
		            . $this->mysqli->connect_error);
		}

	}

	function generaDiccionarioCarreras(){

		$diccionarioCarreras=array();

		$stmt = $this->mysqli->prepare(
		'SELECT carr_id,carr_nombre FROM carrera;');
		//$stmt->bind_param();

		if(  $stmt->execute() ){

			/* bind result variables */
			$stmt->bind_result($carr_id, $carr_nombre);

			/* fetch values */
			while ($stmt->fetch()) {
				$diccionarioCarreras[] = 
					array(
						"idCarrera"=>$carr_id,
						"nombreCarrera"=>$carr_nombre
					);
		    }

		}

		return $diccionarioCarreras;

	}


	function consultaLista(){

		$stmt = $this->mysqli->prepare(
		'SELECT alcu_id,cicl_nombre,curs_nombre,alcu_seccion
			FROM lista
			NATURAL JOIN curso
			NATURAL JOIN cicloescolar');
		
		if(  $stmt->execute() ){

			/* bind result variables */
			$stmt->bind_result($idLista, $nombreCiclo, $nombreCurso, $seccion );

			/* fetch values */
			while( $stmt->fetch() ){
				$diccionario['error'] = false;
				$diccionario['repetirListas'][] = 
					array(
						'idLista'      => $idLista,
						'nombreCiclo'  => $nombreCiclo,
						'nombreCurso'  => $nombreCurso,
						'seccion'      => $seccion
					);
			}
		}
		else{
			$diccionario['error' ] = true;
			$diccionario['mensaje'] = "Error interno, de repetirse favor de reportarlo";
		}
	    /* cerrar sentencia */
	    $stmt->close();
		return $diccionario;
    }


	function consultaListas(){
		return $this->consultaLista();
	}


}
