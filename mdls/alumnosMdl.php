<?php
require_once('ModeloComun.php');
class alumnosMdl extends ModeloComun{
	const ALUMNO = 3;


	function alta( $codigo, $nombre, $paterno, $materno, $carrera, 
		$email='', $celular='', $github='', $website=''
	){
		//Va ir a insertar a la base de datos
		$all_query_ok=true;
		$a=self::ALUMNO;

		$this->mysqli->autocommit(FALSE);

		$query = $this->mysqli->prepare(
		'INSERT INTO usuario(tusu_id,nombre,paterno,materno,codigo)
			VALUES(?,?,?,?,?)');
		$query->bind_param("issss",$a,$nombre,$paterno,$materno,$codigo);
		$query->execute()? null : $all_query_ok=false;
		$last_id = $this->mysqli->insert_id;


		$query = $this->mysqli->prepare(
		'INSERT INTO alumno(usu_id,carr_id,alum_email,alum_celular,alum_github,alum_website)
			VALUES(?,?,?,?,?,?)');
		$query->bind_param("iissss",$last_id,$carrera,$email,$celular,$github,$website);
		$query->execute()? null : $all_query_ok=false;


		$all_query_ok ? $this->mysqli->commit() : $this->mysqli->rollback();

		//si todo salio bien
		return $all_query_ok;
	}
	
	function baja($codigo){
		$all_query_ok=true;
		$query = $this->mysqli->prepare(
		'UPDATE usuario SET activo="N" WHERE codigo=?');
		$query->bind_param("s",$codigo);
		$query->execute()? null : $all_query_ok=false;
		return $all_query_ok;
	}
	
	function consulta($codigo){

		$stmt = $this->mysqli->prepare(
		'SELECT nombre,paterno,
				materno,carr_nombre,
				alum_email,alum_celular,
				alum_github,alum_website 
		 FROM usuario NATURAL JOIN alumno NATURAL JOIN carrera 
		 WHERE codigo=? AND tusu_id=3 AND activo!="N"');
		$stmt->bind_param("s",$codigo);
		
		if(  $stmt->execute() ){

			/* bind result variables */
			$stmt->bind_result(
				$nombre, 	 $paterno,
				$materno,      $carr_nombre, $alum_email,
				$alum_celular, $alum_github, $alum_website
			);

			/* fetch values */
			if( $stmt->fetch() ){
				$alumDatos['error'    ] = false;
				$alumDatos['codigo'   ] = $codigo;
				$alumDatos['nombre'   ] = $nombre;
				$alumDatos['paterno'  ] = $paterno;
				$alumDatos['materno'  ] = $materno;
				$alumDatos['carrera'  ] = $carr_nombre;
				$alumDatos['email'    ] = $alum_email;
				$alumDatos['telefono' ] = $alum_celular;
				$alumDatos['github'   ] = $alum_github;
				$alumDatos['website'  ] = $alum_website;
			}
			else{
		 		$alumDatos['error' ] = true;
				$alumDatos['mensaje'] = "No existe alumno con codigo {$codigo}";
			}
		}
		else{
			$alumDatos['error' ] = true;
			$alumDatos['mensaje'] = "Error interno, de repetirse favor de reportarlo";
		}
	    /* cerrar sentencia */
	    $stmt->close();

		return $alumDatos;
	}
	
	function modificar( $codigo, $nombre, $paterno, $materno, $carrera, 
		$email='', $celular='', $github='', $website=''
	){

		$this->mysqli->autocommit(TRUE);
		$query = $this->mysqli->prepare(
			'UPDATE usuario
			 NATURAL JOIN alumno
			 SET
			 	nombre  = ?,
			 	paterno = ?,
			 	materno = ?,
			 	carr_id = ?,
			 	alum_email   = ?,
			 	alum_celular = ?,
			 	alum_github  = ?,
			 	alum_website = ?
			WHERE codigo  = ?'
		);
		$query->bind_param("sssisssss",
			$nombre,$paterno,$materno,
			$carrera,$email,$celular,
			$github,$website,$codigo);
		
		//returns false or true
		return $query->execute();
	}
}
