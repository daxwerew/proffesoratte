<?php
class alumnosCtrl{
	public $modelo;
	function __construct(){
		//Definimos el modelo
		require('mdls/alumnosMdl.php');
		$this->modelo = new alumnosMdl();
	}
	
	function ejecutar(){
		if( !isset($_GET['accion']) ){
			$error='Alumnos, no hay accion';
			require('vistas/error.php');
			die;
		}


		switch( $_GET['accion'] ){

			case 'alta':
				//Validar datos

					if( !isset($_GET['nrc']) || !isset($_GET['alumnos']) ||
							!isset($_GET['evaluacion']) ){
						$error='no se recibieron datos completos para calificar';
						require('vistas/error.php');
					}

					$nrc = $_GET['nrc'];
					$evaluacion = $_GET['evaluacion'];
					$alumnos = $_GET['alumnos'];


					//alumnos
					if( is_array($alumnos) ){
						$error='alumnos debe ser un arreglo alumno-calificación';
						require('vistas/error.php');
						die;
					}

				
				//Ahora si le hablo al modelo
				$status = $this->modelo->alta($nrc,$evaluacion,$alumnos);
				if( $status ){
					//Cargo vista de bien hecho
					require('vistas/calificacionesInsertado.php');
				}else{
					require('vistas/error.php');
				}
				break;



			case 'modificacion':

				//Validar datos
					if( !isset($_GET['nrc']) || !isset($_GET['alumnos']) ||
							!isset($_GET['evaluacion']) ){
						$error='no se recibieron datos completos para calificar';
						require('vistas/error.php');
					}

					$nrc = $_GET['nrc'];
					$evaluacion = $_GET['evaluacion'];
					$alumnos = $_GET['alumnos'];


					//alumnos
					if( is_array($alumnos) ){
						$error='alumnos debe ser un arreglo alumno-calificación';
						require('vistas/error.php');
						die;
					}

				
				//Ahora si le hablo al modelo
				$status = $this->modelo->modificacion($nrc,$evaluacion,$alumnos);
				if( $status ){
					//Cargo vista de bien hecho
					require('vistas/calificacionesModificado.php');
				}else{
					require('vistas/error.php');
				}
				break;


			case 'consulta':

				//Validar datos
					if( !isset($_GET['nrc']) || !isset($_GET['evaluacion']) ){
						$error='no se recibieron datos completos para consultar';
						require('vistas/error.php');
					}

					$nrc = $_GET['nrc'];
					$evaluacion = $_GET['evaluacion'];

				
					//Ahora si le hablo al modelo
					$status = $this->modelo->consulta($nrc,$evaluacion);
					if( $status ){
						require('vistas/calificacionesConsulta.php');
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
