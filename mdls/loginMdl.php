<?php
require_once('ModeloComun.php');
class loginMdl extends ModeloComun{
	
	function buscarUsuario($codigo,$password){

		$query = $this->mysqli->prepare(
		"SELECT
				codigo,
				nombre,paterno,materno,
				ctrl_nombre,acci_nombre
			FROM usuario 
				NATURAL JOIN tipousuario
				NATURAL JOIN permisos
				NATURAL JOIN controlador_accion
				NATURAL JOIN controlador
				NATURAL JOIN accion
			WHERE
				codigo = ? AND 
				password = ?"
		);
		$query->bind_param("ss",$codigo,$password);
		$query->execute();

		$resulset = $query->get_result();

		if( $resulset->num_rows )
		{

			$tupla = $resulset->fetch_assoc();
			$usuarioDatos['codigo'] = $tupla['codigo'];
			$usuarioDatos['nombre'] = $tupla['nombre'];
			$usuarioDatos['nombre_completo'] = "{$tupla['nombre']} {$tupla['paterno']} {$tupla['materno']}";
			
			do{
				$usuarioDatos[$tupla['ctrl_nombre']][$tupla['acci_nombre']]=true;
			}
			while ($tupla = $resulset->fetch_assoc());
		}
		else
		{
			$usuarioDatos = false;
		}
		return $usuarioDatos;
	}

}
