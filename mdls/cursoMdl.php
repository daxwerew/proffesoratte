<?php
require_once('ModeloComun.php');
class cursoMdl extends ModeloComun{

	function alta($clave, $nombre, $departamento = ""){ /*,$evaluacion,$rubros*/

		$all_query_ok=true;

		$this->mysqli->autocommit(FALSE);

		$query = $this->mysqli->prepare(
		'INSERT INTO curso(curs_clave,curs_nombre,curs_departamento)
			VALUES(?,?,?)');
		$query->bind_param("sss",$clave,$nombre,$departamento);
		$query->execute()? null : $all_query_ok=false;

		$all_query_ok ? $this->mysqli->commit() : $this->mysqli->rollback();

		//si todo salio bien
		return $all_query_ok;
	}
	


	function baja($clave){

		$stmt = $this->mysqli->prepare(
		'DELETE FROM curso WHERE curs_clave=?');
		$stmt->bind_param("s",$clave);
		
		if(  $stmt->execute() ){
	 		$respuesta['error' ] = false;
			$respuesta['mensaje'] = "Se borro tu cursito online";
			
		}
		else{
			$respuesta['error' ] = true;
			$respuesta['mensaje'] = "No se pudo borrar curso, verifique que no existan listas asociadas";
		}
		return $respuesta;
	}
	


	function consulta($clave){

		$stmt = $this->mysqli->prepare(
		'SELECT curs_nombre,curs_departamento
		 FROM curso 
		 WHERE curs_clave=?');
		$stmt->bind_param("s",$clave);
		
		if(  $stmt->execute() ){

			/* bind result variables */
			$stmt->bind_result( $nombre, $departamento );

			/* fetch values */
			if( $stmt->fetch() ){
				$respuesta['error'    ] = false;
				$respuesta['clave'    ] = $clave;
				$respuesta['nombre'   ] = $nombre;
				$respuesta['departamento' ] = $departamento;
			}
			else{
		 		$respuesta['error' ] = true;
				$respuesta['mensaje'] = "No existe curso";
			}
		}
		else{
			$respuesta['error' ] = true;
			$respuesta['mensaje'] = "Error interno, de repetirse favor de reportarlo";
		}
		return $respuesta;
	}



}
