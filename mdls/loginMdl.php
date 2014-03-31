<?php
require_once('ModeloComun.php');
class loginMdl extends ModeloComun{
	
	function buscarUsuario($codigo,$password){

		$stmt = $this->mysqli->prepare(
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
		$stmt->bind_param("ss",$codigo,$password);
		
		if( $stmt->execute() )
		{
			/* bind result variables */
			$stmt->bind_result($codigo, $nombre, $paterno, $materno, $ctrl_nombre, $acci_nombre);

			/* fetch values */
			$stmt->fetch();
			$usuarioDatos['codigo'] = $codigo;
			$usuarioDatos['nombre'] = $nombre;
			$usuarioDatos['nombre_completo'] = "{$nombre} {$paterno} {$materno}";

		    do{
		        $usuarioDatos[$ctrl_nombre][$acci_nombre]=true;
		    }
		    while( $stmt->fetch() );
		}
		else
		{
			$usuarioDatos = false;
		}

	    /* close statement */
	    $stmt->close();
	    
		return $usuarioDatos;
	}

}
