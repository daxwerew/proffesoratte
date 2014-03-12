<?php
class asistenciasCtrl{
	public $modelo;
	function __construct(){
		//Definimos el modelo
		require('mdls/asistenciasMdl.php');
		$this->modelo = new asistenciasMdl();
	}
	
	function ejecutar(){
		if( !isset($_GET['accion']) ){
			$error='no hay accion';
			require('vistas/error.php');
			die;
		}


		switch( $_GET['accion'] ){

			case 'alta':
				//Validar datos, arreglo[codigo]=asistencia , fecha
					if( !isset($_GET['grupo']) || !isset($_GET['fecha']) || !isset($_GET['alumnos']) ){
						$error='no se recibieron datos completos para macar asistencias';
						require('vistas/error.php');
					}
					$alumnos = $_GET['alumnos'];
					$fecha   = $_GET['fecha'];
					$grupo = $_GET['grupo'];

					//Alumnos
					if( !is_array($alumnos) ){
						$error='no se recibio lista de alumnos';
						require('vistas/error.php');
						die;
					}

					//aqui validare fecha, todavia no se como la voy a enviar
				
				//Ahora si le hablo al modelo
				$status = $this->modelo->alta($grupo,$alumnos,$fecha);
				if( $status ){
					//Cargo vista de bien hecho
					require('vistas/asistenciasInsertadas.php');
				}else{
					require('vistas/error.php');
				}
				break;


			case 'modificacion':
					//Validar datos

					if( !isset($_GET['grupo']) || !isset($_GET['alumnos']) || !isset($_GET['fecha'])  ){
						$error='no se recibio datos para modificacion';
						require('vistas/error.php');
					}
					$alumnos = $_GET['alumnos'];
					$fecha = $_GET['fecha'];
					$grupo = $_GET['grupo'];


					//Alumnos
					if( !is_array($alumnos) ){
						$error='no se recibio lista de alumnos';
						require('vistas/error.php');
						die;
					}

				
					//Ahora si le hablo al modelo
					$status = $this->modelo->modifica($grupo,$alumnos,$fecha);
					if( $status ){
						require('vistas/asistenciaConsulta.php');
					}else{
						$error = 'Ocurrio un error al modificar';
						require('vistas/error.php');
					}

				break;


			case 'consulta':
					//Validar datos
					if( !isset($_GET['grupo']) ){
						$error='no se recibio datos para consulta';
						require('vistas/error.php');
					}
					$grupo = $_GET['grupo'];


				
					//Ahora si le hablo al modelo
					$status = $this->modelo->consulta($grupo);
					if( $status ){
						require('vistas/asistenciaConsulta.php');
					}else{
						$error = 'Ocurrio un error al consultar alumno';
						require('vistas/error.php');
					}


				break;


			default:
				$error='Accion Incorrecta';
				require('vistas/error.php');
		}
	}
}
