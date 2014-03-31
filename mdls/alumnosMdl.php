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
		'UPDATE usuario SET activo=´N´ WHERE codigo=?');
		$query->bind_param("s",$codigo);
		$query->execute()? null : $all_query_ok=false;
		return $all_query_ok;
	}
	
	function consulta($codigo){

		$query = $this->mysqli->prepare(
		'SELECT codigo,nombre,paterno,
				materno,carr_nombre,
				alum_email,alum_celular,
				alum_github,alum_website 
		 FROM usuario NATURAL JOIN alumno NATURAL JOIN carrera 
		 WHERE codigo=? AND tusu_id=3');
		$query->bind_param("s",$codigo);
		
		if(  $query->execute() ){

			$resulset = $query->get_result();

			if( $resulset->num_rows > 0 ){
				$tupla = $resulset->fetch_assoc();
	
				$alumDatos['codigo'] = $tupla['codigo'];
				$alumDatos['nombre'] = $tupla['nombre'];
				$alumDatos['nombre_completo'] = "{$tupla['nombre']} {$tupla['paterno']} {$tupla['materno']}";
				$alumDatos['carrera'] = $tupla['carr_nombre'];
				$alumDatos['email'] = $tupla['alum_email'];
				$alumDatos['celular'] = $tupla['alum_celular'];
				$alumDatos['github'] = $tupla['alum_github'];
				$alumDatos['website'] = $tupla['alum_website'];
			}
			else
				$alumDatos=false;
		}
		else
		 	$alumDatos=false;
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
