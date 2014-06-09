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
					if( empty($_POST) ){
						//Cargar Formulario
						$diccionario = $this->modelo->consultaListas();
						$this->generaPaginaDesdePlantila('calificaciones/formulario.html', $diccionario);
						die;
					}

					//Validating
					$arregloVars = $this->validateVars(
						$_POST,
						array(
							'codigo'     => '/^[A-Z0-9]{7,9}$/i',
							'nombre'     => '/^[a-z| ]+$/i',
						)
					);

					$grupo = $_GET['grupo'];
					$evaluacion = $_GET['evaluacion'];
					$alumnos = $_GET['alumnos'];


					if( !is_array($alumnos) ){
						$error='alumnos debe ser un arreglo alumno-calificación';
						require('vistas/error.php');
					}

				//Model Call
				$status = $this->modelo->alta($grupo,$evaluacion,$alumnos);
				if( $status ){
					require('vistas/calificaciones/insertado.php');
				}else{
					require('vistas/error.php');
				}
				break;


			case 'consultaGrupo':
					//Validations
					$arregloVars = $this->validateVars($_POST,array(
						'idLista'     => '/^[0-9]{1,9}$/i'
					));
					extract($arregloVars);

					//Model
					$respuesta = $this->modelo->consultaEvaluandosLista($idLista);
					if( !$respuesta['error'] ){
						echo json_encode($respuesta);die;
					}
					else{
						$this->errorComun($respuesta['mensaje']);
						die;
					}


				break;



			case 'modificar':

					//Validating
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

				
				//Model call
				$status = $this->modelo->modificar($grupo,$evaluacion,$alumnos);
				if( $status ){
					require('vistas/calificaciones/modificado.php');
				}else{
					require('vistas/error.php');
				}
				break;


			default:
				$error='Accion Incorrecta';
				require('vistas/error.php');
		}
	}
}
