<?php
require_once('ControladorComun.php');
class alumnosCtrl extends ControladorComun{
	
	function ejecutar(){
		if( !isset($_GET['accion']) ){
			$error='Alumnos, no hay accion';
			require('vistas/error.php');
		}


		switch( $_GET['accion'] ){

			case 'alta':
					//Validations
					if( !isset($_GET['nombre']) || !isset($_GET['codigo']) ||
							!isset($_GET['carrera']) || !isset($_GET['email']) ){
						$error='no se recibieron datos completos para dar de alta un alumno';
						require('vistas/error.php');
					}
					$nombre = $_GET['nombre'];
					$codigo = $_GET['codigo'];
					$carrera = $_GET['carrera'];
					$email   = $_GET['email'];

					//alumno name
					if( !preg_match('/^[a-z| ]+$/i',$nombre) ){
						$error="nombre de alumno $nombre no convencional";
						require('vistas/error.php');
					}

					//email
					if( !preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i",$email) ){
						$error='nombre de alumno no convencional';
						require('vistas/error.php');
					}

				//Model call
				$status = $this->modelo->alta($nombre,$codigo,$carrera,$email);
				if( $status ){
					require('vistas/alumnos/insertado.php');
				}else{
					require('vistas/error.php');
				}
				break;


			case 'baja':
					//Validations

					if(  !isset($_GET['codigo'])  ){
						$error='no se recibio codigo';
						require('vistas/error.php');
					}
					$codigo = $_GET['codigo'];

				
					$status = $this->modelo->baja($codigo);
					if( $status ){
						require('vistas/alumnos/borrado.php');
					}else{
						$error = 'Ocurrio un error al dar de baja';
						require('vistas/error.php');
					}

				break;


			case 'consulta':

					if(  !isset($_GET['codigo'])  ){
						$error='no se recibio codigo';
						require('vistas/error.php');
					}
					$codigo = $_GET['codigo'];


					$resultado = $this->modelo->consulta($codigo);
					if( $resultado ){
						require('vistas/alumnos/consulta.php');
					}else{
						$error = 'Ocurrio un error al consultar alumno';
						require('vistas/error.php');
					}


				break;
			case 'modificar':

					if( !isset($_GET['codigo']) ){
						$error='no se recibieron datos completos para modificar alumno';
						require('vistas/error.php');
					}

					$codigo = $_GET['codigo'];
					$nombre = isset($_GET['nombre'])?$_GET['nombre']:null;
					$carrera = isset($_GET['carrera'])?$_GET['carrera']:null;
					$email   = isset($_GET['email'])?$_GET['email']:null;

					if( isset($nombre) && !preg_match("/^[a-z| ]+$/i",$nombre) ){
						$error='nombre de alumno no convencional';
						require('vistas/error.php');
					}

					if( isset($email) && !preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i",$email) ){
						$error='nombre de alumno no convencional';
						require('vistas/error.php');
					}

				
				$resultado = $this->modelo->modificar($nombre,$codigo,$carrera,$email);
				if( $resultado ){
					require('vistas/alumnos/consulta.php');
				}else{
					require('vistas/error.php');
				}
				break;


			default:
				$error='Alumno, Accion Incorrecta';
				require('vistas/error.php');
		}
	}
}
