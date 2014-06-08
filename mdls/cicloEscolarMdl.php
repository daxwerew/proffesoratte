<?php
require_once('ModeloComun.php');
class cicloEscolarMdl extends ModeloComun{
	
	function alta($ciclo,$fechasCiclo){

		//Va ir a insertar a la base de datos
		$all_query_ok=true;

		$this->mysqli->autocommit(FALSE);

		$query = $this->mysqli->prepare(
			'INSERT INTO cicloescolar(cicl_nombre,cicl_inciio,cicl_fin)
			 VALUES(?,?,?)'
		);
		$query->bind_param("sss",$ciclo,$fechasCiclo[0],$fechasCiclo[count($fechasCiclo)-1]);
		$query->execute()? null : $all_query_ok=false;
		$last_id = $this->mysqli->insert_id;


		$query = $this->mysqli->prepare(
			'INSERT INTO fechas_del_ciclo(cicl_id,fecl_fecha)
			 VALUES(?,?)');

		foreach($fechasCiclo as $fecha){
			$query->bind_param("is",$last_id,$fecha);
			$query->execute()? null : $all_query_ok=false;
		}

		$all_query_ok ? $this->mysqli->commit() : $this->mysqli->rollback();

		//si todo salio bien
		return $all_query_ok;

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
