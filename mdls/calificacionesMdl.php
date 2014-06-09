<?php
require_once('ModeloComun.php');
class calificacionesMdl extends ModeloComun{
	public $bd_driver;
	
	function alta($grupo,$evaluacion,$alumnos){
		//Va ir a insertar a la base de datos
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
	
	function modificar($grupo,$evaluacion,$alumnos){
		
		//si todo salio bien
		return true;
		//sino
		return false;
	}
	
	function consultaEvaluandosLista($grupo){

		$stmt = $this->mysqli->prepare(
		'SELECT lial_id,codigo,nombre,paterno,materno
			FROM lista
			NATURAL JOIN lista_alumnos
			NATURAL JOIN usuario
		 WHERE alcu_id=? AND tusu_id=3 AND activo!="N"');
		$stmt->bind_param("i",$grupo);
		
		if(  $stmt->execute() ){

			/* bind result variables */
			$stmt->bind_result( $lial_id, $codigo, $nombre, $paterno, $materno );

	 		$respuesta['error' ] = false;

			/* fetch values */
			while( $stmt->fetch() ){
				$respuesta['alumnos'][]= array(
					'lial_id'   => $lial_id,
					'codigo'    => $codigo,
					'nombre'    => $nombre,
					'paterno'   => $paterno,
					'materno'   => $materno
				);
			}
			
		}
		else{
			$respuesta['error' ] = true;
			$respuesta['mensaje'] = "Error interno, de repetirse favor de reportarlo";
		}
	    /* cerrar sentencia */
	    $stmt->close();

	    //Consulta evaluaciones
		$stmt = $this->mysqli->prepare(
		'SELECT eval_id,eval_nombre
			FROM lista
			NATURAL JOIN evaluacion
		 WHERE alcu_id=?');
		$stmt->bind_param("i",$grupo);
		
		if(  $stmt->execute() ){

			/* bind result variables */
			$stmt->bind_result( $idEvaluacion, $nombreEvaluacion );

			/* fetch values */
			while( $stmt->fetch() ){
				$respuesta['evaluaciones'][] = array(
					'idEvaluacion'     => $idEvaluacion,
					'nombreEvaluacion' => $nombreEvaluacion
				);
			}

		}
		else{
			$respuesta['error' ] = true;
			$respuesta['mensaje'] = "Error interno, de repetirse favor de reportarlo";
		}
	    /* cerrar sentencia */
	    $stmt->close();

		return $respuesta;
	}
}
