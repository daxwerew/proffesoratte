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
					$arregloVars = $this->validateVars($_POST,array(
						'codigo'     => '/^[A-Z0-9]{7,9}$/i',
						'nombre'     => '/^[a-z| ]+$/i',
						'paterno'    => '/^[a-z| ]+$/i',
						'materno'    => '/^[a-z| ]+$/i',
						'carrera'    => '/^[0-9]+$/i',
						'email'      => '/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i'
					));

					if( $arregloVars[0]===false ){
						$error="{$arregloVars[1]}, {$arregloVars[2]}";
						require('vistas/error.php');die;
					}

					extract($arregloVars);

				//Model call
				$status = $this->modelo->alta($codigo,$nombre,$paterno,$materno,$carrera,$email);
				if( $status ){
					require('vistas/alumnos/insertado.php');
				}else{
					$error='Error en el modelin';
					require('vistas/error.php');
				}
				break;


			case 'baja':
					//Validations
					$arregloVars = $this->validateVars($_POST,array(
						'codigo'     => '/^[A-Z0-9]{7,9}$/i'
					));

					if( $arregloVars[0]===false ){
						$error="{$arregloVars[1]}, {$arregloVars[2]}";
						require('vistas/error.php');die;
					}

					extract($arregloVars);

				
					$status = $this->modelo->baja($codigo);
					if( $status ){
						require('vistas/alumnos/borrado.php');
					}else{
						$error = 'Ocurrio un error al dar de baja';
						require('vistas/error.php');
					}

				break;


			case 'consulta':
					//Validations
					$arregloVars = $this->validateVars($_POST,array(
						'codigo'     => '/^[A-Z0-9]{7,9}$/i'
					));

					if( $arregloVars[0]===false ){
						$error="{$arregloVars[1]}, {$arregloVars[2]}";
						require('vistas/error.php');die;
					}
					extract($arregloVars);

					//Model
					$resultado = $this->modelo->consulta($codigo);
					if( $resultado ){
						$vision = print_r($resultado,1);
						require('vistas/visionTemporal.php');
					}else{
						$error = 'Ocurrio un error al consultar alumno';
						require('vistas/error.php');
					}


				break;
			case 'modificar':
				//Validations
				$arregloVars = $this->validateVars($_POST,array(
					'codigo'     => '/^[A-Z0-9]{7,9}$/i',
					'nombre'     => '/^[a-z| ]+$/i',
					'paterno'    => '/^[a-z| ]+$/i',
					'materno'    => '/^[a-z| ]+$/i',
					'carrera'    => '/^[0-9]+$/i',
					'email'      => '/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i',
					'celular'    => '/^[0-9]{6,14}$/i',
					'github'     => '/^.+$/i',//REMINDER, PUT URL REGEXP
					'website'     => '/^.+$/i',//REMINDER, PUT URL REGEXP
				));

				if( $arregloVars[0]===false ){
					$error="{$arregloVars[1]}, {$arregloVars[2]}";
					require('vistas/error.php');die;
				}

				extract($arregloVars);

				//Model
				$resultado = $this->modelo->modificar(
									$codigo,$nombre,$paterno,
									$materno,$carrera,$email,
									$celular, $github, $website);
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
