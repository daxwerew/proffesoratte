<?php
require_once('ControladorComun.php');
class calificacionesCtrl extends ControladorComun{
	
	function ejecutar(){
		if( !isset($_GET['accion']) ){
			$error='Alumnos, no hay accion';
			require('vistas/error.php');
			die;
		}


		switch( $_GET['accion'] ){

			case 'alta':
				//Validar datos

					if( !isset($_GET['grupo']) || !isset($_GET['alumnos']) ||
							!isset($_GET['evaluacion']) ){
						$error='no se recibieron datos completos para calificar';
						require('vistas/error.php');
					}

					$grupo = $_GET['grupo'];
					$evaluacion = $_GET['evaluacion'];
					$alumnos = $_GET['alumnos'];


					//alumnos
					if( !is_array($alumnos) ){
						$error='alumnos debe ser un arreglo alumno-calificación';
						require('vistas/error.php');
					}

				
				//Ahora si le hablo al modelo
				$status = $this->modelo->alta($grupo,$evaluacion,$alumnos);
				if( $status ){
					//Cargo vista de bien hecho
					require('vistas/calificaciones/insertado.php');
				}else{
					require('vistas/error.php');
				}
				break;



			case 'modificar':

				//Validar datos
					if( !isset($_GET['grupo']) || !isset($_GET['alumnos']) ||
							!isset($_GET['evaluacion']) ){
						$error='no se recibieron datos completos para calificar';
						require('vistas/error.php');
					}

					$grupo = $_GET['grupo'];
					$evaluacion = $_GET['evaluacion'];
					$alumnos = $_GET['alumnos'];


					//alumnos
					if( !is_array($alumnos) ){
						$error='alumnos debe ser un arreglo alumno-calificación';
						require('vistas/error.php');
						die;
					}

				
				//Ahora si le hablo al modelo
				$status = $this->modelo->modificar($grupo,$evaluacion,$alumnos);
				if( $status ){
					//Cargo vista de bien hecho
					require('vistas/calificaciones/modificado.php');
				}else{
					require('vistas/error.php');
				}
				break;


			case 'consulta':

				//Validar datos
					if( !isset($_GET['grupo']) || !isset($_GET['evaluacion']) ){
						$error='no se recibieron datos completos para consultar';
						require('vistas/error.php');
					}

					$grupo = $_GET['grupo'];
					$evaluacion = $_GET['evaluacion'];

				
					//Ahora si le hablo al modelo
					$status = $this->modelo->consulta($grupo,$evaluacion);
					if( $status ){
						require('vistas/calificaciones/consulta.php');
					}else{
						$error = 'Ocurrio un error al consultar calificaciones';
						require('vistas/error.php');
					}


				break;


			default:
				$error='Accion Incorrecta';
				require('vistas/error.php');
		}
	}
}
