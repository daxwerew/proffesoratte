<?php
require_once('ModeloComun.php');
class evaluacionMdl extends ModeloComun{

	function alta($lista,$nombreEvaluacion,$porcentajes){ /*,$evaluacion,$rubros*/

		$all_query_ok=true;

		$this->mysqli->autocommit(false);

		$query = $this->mysqli->prepare(
		'INSERT INTO evaluacion(alcu_id,eval_nombre,eval_porcentaje)
			VALUES(?,?,?)');

		$vecesARepetir = count($nombreEvaluacion);
		
		for($i=0; $i<$vecesARepetir; $i++ ){
			
			if( $all_query_ok ){
				$query->bind_param("iss",$lista,$nombreEvaluacion[$i],$porcentajes[$i]);
				$query->execute()? null : $all_query_ok=false;
			}
			else{
				break;
			}

		}

		$all_query_ok ? $this->mysqli->commit() : $this->mysqli->rollback();

		//si todo salio bien
		return $all_query_ok;
	}



}
