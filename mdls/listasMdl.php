<?php
require_once('ModeloComun.php');
class listasMdl extends ModeloComun{
	
	function alta($cicloEscolar,$curso,$seccion){
		//Va ir a insertar a la base de datos
		$all_query_ok=true;

		$query = $this->mysqli->prepare(
		'INSERT INTO lista(cicl_id,curs_id,alcu_seccion)
			VALUES(?,?,?)');
		$query->bind_param("iis",$cicloEscolar,$curso,$seccion);

		$query->execute()? null : $all_query_ok=false;

		return $all_query_ok;

	}


	function altaAlumnos($lista, $alumnos){
		$all_query_ok=true;

		$query = $this->mysqli->prepare(
		'INSERT INTO lista_alumnos(alcu_id,usu_id)
			VALUES(?,?)');

		foreach($alumnos as $alumno){
			$query->bind_param("ii",$lista,$alumno);
			$query->execute()? null : $all_query_ok=false;
		}
		return $all_query_ok;

	}

	function consultaAlumnos(){
		$stmt = $this->mysqli->prepare(
		'SELECT usu_id,codigo,nombre,paterno,materno
			FROM usuario
			NATURAL JOIN alumno');
		
		if(  $stmt->execute() ){

			/* bind result variables */
			$stmt->bind_result($idAlumno,$codigo,$nombre,$paterno,$materno );

			/* fetch values */
			while( $stmt->fetch() ){
				$diccionario['repetirAlumnos'][] = 
					array(
						'idAlumno'   => $idAlumno,
						'codigo'     => $codigo,
						'nombre'     => $nombre,
						'paterno'    => $paterno,
						'materno'    => $materno
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

	function consultaAlumnosLista($idLista){

		$stmt = $this->mysqli->prepare(
		'SELECT cicl_nombre,curs_nombre,alcu_seccion,usu_id,codigo,nombre,paterno,materno
			FROM lista_alumnos
			NATURAL JOIN lista
			NATURAL JOIN usuario
			NATURAL JOIN curso
			NATURAL JOIN cicloescolar
			WHERE alcu_id=? AND lial_activo="S"'
		);
		$stmt->bind_param("i",$idLista);
		
		if(  $stmt->execute() ){

			/* bind result variables */
			$stmt->bind_result(
				$cicloEscolar, $materia, $seccion,
				$usu_id, $codigo, $nombre, $paterno, $materno
			);

			/* fetch values */
			if( $stmt->fetch() ){
				$diccionario['error'  ] = false;
				$diccionario['cicloEscolar'] = $cicloEscolar;
				$diccionario['materia'     ] = $materia;
				$diccionario['seccion'     ] = $seccion;
				$diccionario['repetirAlumnos'][] = 
					array(
						'idAlumno' => $usu_id, 
						'codigo'   => $codigo, 
						'nombre'   => $nombre, 
						'paterno'  => $paterno, 
						'materno'  => $materno
					);
			}
			else{
				$diccionario['error'  ] = true;
				$diccionario['mensaje'] = "No existe lista con ese id";
			}

			while( $stmt->fetch() ){
				$diccionario['repetirAlumnos'][] = 
					array(
						'idAlumno' => $usu_id, 
						'codigo'   => $codigo, 
						'nombre'   => $nombre, 
						'paterno'  => $paterno, 
						'materno'  => $materno
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
	function tieneEvaluacion($idLista){

		$stmt = $this->mysqli->prepare(
		'SELECT count(*) as cantidad
		 FROM evaluacion
		 WHERE alcu_id=?');
		$stmt->bind_param("s",$idLista);
		
		if(  $stmt->execute() ){
			/* bind result variables */
			$stmt->bind_result( $cantidad );

			/* fetch values */
			if( $stmt->fetch() ){
				if( $cantidad>0 ){
					return true;
				}
				else{
					return false;//'No hay evaluaciones para este grupo';
				}
			}else{
				return 'No existe lista';
			}
		}
		else{
			return 'Error al consultar evaluaciones';
		}
	    /* cerrar sentencia */
	    $stmt->close();

	}
	function generaDiccionarioAltaLista(){


		$stmt = $this->mysqli->prepare(
		'SELECT cicl_id,cicl_nombre
		 FROM cicloescolar');
		//$stmt->bind_param("s",$codigo);
		
		if(  $stmt->execute() ){

			/* bind result variables */
			$stmt->bind_result( $idCicloEscolar, $nombreCicloEscolar);

			/* fetch values */
			while( $stmt->fetch() ){
				$diccionario['error'    ] = false;
				$diccionario['repetirCicloEscolar'][] = 
					array(
						'idCicloEscolar'      => $idCicloEscolar,
						'nombreCicloEscolar'  => $nombreCicloEscolar
					);
			}
		}
		else{
			$diccionario['error' ] = true;
			$diccionario['mensaje'] = "Error interno, de repetirse favor de reportarlo";
			return $diccionario;
		}
	    /* cerrar sentencia */
	    $stmt->close();


		$stmt = $this->mysqli->prepare(
			'SELECT curs_id,curs_clave,curs_nombre
		 	 FROM curso'
		 );

		if(  $stmt->execute() ){

			/* bind result variables */
			$stmt->bind_result( $idCurso, $nombreCurso1, $nombreCurso2);

			/* fetch values */
			while( $stmt->fetch() ){
				$diccionario['error'    ] = false;
				$diccionario['repetirCurso'][] = 
					array(
						'idCurso'      => $idCurso,
						'nombreCurso'  => "$nombreCurso1 $nombreCurso2"
					);
			}
		}
		else{
			$diccionario['error' ] = true;
			$diccionario['mensaje'] = "Error interno, de repetirse favor de reportarlo";
			return $diccionario;
		}
		$diccionario['seccion']='';
		
		return $diccionario;
	}
}
