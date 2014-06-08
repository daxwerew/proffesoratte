<?php
require_once('ControladorComun.php');
class cicloEscolarCtrl extends ControladorComun{
	
	function ejecutar(){
		if( !isset($_GET['accion']) ){
			$error='No hay accion';
			require('vistas/error.php');
		}


		switch( $_GET['accion'] ){

			case 'alta':
				//Validar datos


					if( empty($_POST) ){
						//Cargar Formulario
						$this->generaPaginaDesdePlantila(
							'cicloEscolar/formulario.html',
							array(
								'accion'      => 'alta',
								'ciclo'       => '',
								'fechaInicio' => '',
								'fechaFinal'  => ''
							)
						);
						die;
					}

					//Validar Variables recibidas
					$arregloVars = $this->validateVars(
						$_POST,
						array(
							'ciclo' => "/^2[01][0-9]{2}[ABV]$/i",
							'fechaInicio' => '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/i',
							'fechaFinal'  => '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/i'
						)
					);
					extract($arregloVars);

					//$diasSemana = $_GET['diasSemana'];

					//Calcula dias validos entre fechaInicio y fechaFin con  diasSemana dados
					//Se creara arreglo $fechasCiclo
					$fechasCiclo=array();

					$arre_diasem=array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes');

					$un_dia = 86400;
					$dia_ini = strtotime($fechaInicio);
					$dia_fin = strtotime($fechaFinal);

					while( $dia_ini<$dia_fin ){
						//if( in_array(date('w',$dia_ini),$diasSemana) ){
							$fechasCiclo[] = date("Y-m-d",$dia_ini);
						//}
						$dia_ini += $un_dia;
					}
				
				//Ahora si le hablo al modelo
				$status = $this->modelo->alta($ciclo,$fechasCiclo);
				if( $status ){
					$this->generaPaginaDesdePlantila('exitoGenerico.html', array(
						'mensaje'=>"Se dio de alta ciclo escolar $ciclo"
					));
				}
				else{
					$this->errorComun('No se pudo dar de alta ciclo');
				}
				break;



			case 'modificar':
				//Validar datos
					if( !isset($_GET['ciclo']) || isset($_GET['festivos']) ){
						$error='no se recibieron datos completos para dar de alta del ciclo';
						require('vistas/error.php');
					}
					//valida festivos
					if( !is_array($_GET['festivos']) ){
						$error='festivos debe ser arreglo de fechas';
						require('vistas/error.php');
					}

					$ciclo = $_GET['ciclo'];
					$festivos = $_GET['festivos'];


					//ciclo
					if( !preg_match("/^2[0-9]{3}[ABV]$/i",$ciclo) ){
						$error='ciclo no valido';
						require('vistas/error.php');
					}

				
				//Ahora si le hablo al modelo
				$status = $this->modelo->modificacion($ciclo,$festivos);
				if( $status ){
					//Cargo vista de bien hecho
					require('vistas/cicloEscolar/modificacion.php');
				}else{
					require('vistas/error.php');
				}
				break;


			case 'baja':
				//Validar datos
					if( !isset($_GET['ciclo']) ){
						$error='no se recibio ciclo';
						require('vistas/error.php');
					}

					$ciclo = $_GET['ciclo'];

					//ciclo
					if( !preg_match("/^2[0-9]{3}[ABV]$/i",$ciclo) ){
						$error='ciclo no valido';
						require('vistas/error.php');
					}

					//Ahora si le hablo al modelo
					$status = $this->modelo->baja($ciclo);
					if( $status ){
						//Cargo vista de bien hecho
						require('vistas/cicloEscolar/baja.php');
					}else{
						require('vistas/error.php');
					}
				break;


			case 'consulta':
				//Validar datos
					if( !isset($_GET['ciclo']) ){
						$error='no se recibio ciclo';
						require('vistas/error.php');
					}

					$ciclo = $_GET['ciclo'];

					//ciclo
					if( !preg_match("/^2[0-9]{3}[ABV]$/i",$ciclo) ){
						$error='ciclo no valido';
						require('vistas/error.php');
					}

					//Ahora si le hablo al modelo
					$datos = $this->modelo->consulta($ciclo);
					if( $datos ){
						//Cargo vista de bien hecho
						require('vistas/cicloEscolar/consulta.php');
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
