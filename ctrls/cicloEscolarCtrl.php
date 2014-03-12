<?php
class cicloEscolarCtrl{
	public $modelo;
	function __construct(){
		//Definimos el modelo
		require('mdls/cicloEscolarMdl.php');
		$this->modelo = new cicloEscolarMdl();
	}
	
	function ejecutar(){
		if( !isset($_GET['accion']) ){
			$error='No hay accion';
			require('vistas/error.php');
			die;
		}


		switch( $_GET['accion'] ){

			case 'alta':
				//Validar datos

					if( !isset($_GET['ciclo']) || !isset($_GET['fechaInicio']) ||
							!isset($_GET['fechaFinal']) ){
						$error='no se recibieron datos completos para dar de alta del ciclo';
						require('vistas/error.php');
						die;
					}
					//valida festivos opcional
					if( isset($_GET['festivos']) ){
						if( !is_array($_GET['festivos']) ){
							$error='festivos debe ser arreglo de fechas';
							require('vistas/error.php');
							die;
						}
					}else{
						$_GET['festivos']=array();
					}

					$ciclo = $_GET['ciclo'];
					$fechaInicio = $_GET['fechaInicio'];
					$fechaFinal = $_GET['fechaFinal'];
					$festivos = $_GET['festivos'];


					//Nombre
					if( !preg_match("/^2[0-9]{3}[ABV]$/i",$ciclo) ){
						$error='ciclo no valido';
						require('vistas/error.php');
						die;
					}

				
				//Ahora si le hablo al modelo
				$status = $this->modelo->alta($ciclo,$fechaInicio,$fechaFinal,$festivos);
				if( $status ){
					//Cargo vista de bien hecho
					require('vistas/cicloEscolarInsertado.php');
				}else{
					require('vistas/error.php');
				}
				break;



			case 'modificacion':
				//Validar datos
					if( !isset($_GET['ciclo']) || !isset($_GET['fechaInicio']) ||
							!isset($_GET['fechaFinal']) ){
						$error='no se recibieron datos completos para dar de alta del ciclo';
						require('vistas/error.php');
						die;
					}
					//valida festivos opcional
					if( isset($_GET['festivos']) ){
						if( !is_array($_GET['festivos']) ){
							$error='festivos debe ser arreglo de fechas';
							require('vistas/error.php');
							die;
						}
					}else{
						$_GET['festivos']=array();
					}

					$ciclo = $_GET['ciclo'];
					$fechaInicio = $_GET['fechaInicio'];
					$fechaFinal = $_GET['fechaFinal'];
					$festivos = $_GET['festivos'];


					//Nombre
					if( !preg_match("/^2[0-9]{3}[ABV]$/i",$ciclo) ){
						$error='ciclo no valido';
						require('vistas/error.php');
						die;
					}

				
				//Ahora si le hablo al modelo
				$status = $this->modelo->modificacion($ciclo,$fechaInicio,$fechaFinal,$festivos);
				if( $status ){
					//Cargo vista de bien hecho
					require('vistas/cicloEscolarModificacion.php');
				}else{
					require('vistas/error.php');
				}
				break;


			case 'consulta':
				require('vistas/cicloEscolarConsulta.php');
				break;


			default:
				$error='Accion Incorrecta';
				require('vistas/error.php');
		}
	}
}
