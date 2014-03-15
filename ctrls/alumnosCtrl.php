<?php
require_once('ControladorComun.php');
class alumnosCtrl extends ControladorComun{
	/*
	public $modelo;
	function __construct(){
		//Definimos el modelo
		require('mdls/alumnosMdl.php');
		$this->modelo = new alumnosMdl();
	}*/
	
	function ejecutar(){
		if( !isset($_GET['accion']) ){
			$error='Alumnos, no hay accion';
			require('vistas/error.php');
		}


		switch( $_GET['accion'] ){

			case 'alta':
				//Validar datos

					if( !isset($_GET['nombre']) || !isset($_GET['codigo']) ||
							!isset($_GET['carrera']) || !isset($_GET['email']) ){
						$error='no se recibieron datos completos para dar de alta un alumno';
						require('vistas/error.php');
					}
					$nombre = $_GET['nombre'];
					$codigo = $_GET['codigo'];
					$carrera = $_GET['carrera'];
					$email   = $_GET['email'];

					//Nombre
					if( !preg_match("/^([a-z| ]+$/i",$nombre) ){
						$error='nombre de alumno no convencional';
						require('vistas/error.php');
					}

					//email
					if( !preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i",$email) ){
						$error='nombre de alumno no convencional';
						require('vistas/error.php');
					}

				
				//Ahora si le hablo al modelo
				$status = $this->modelo->alta($nombre,$codigo,$carrera,$email);
				if( $status ){
					//Cargo vista de bien hecho
					require('vistas/alumnoInsertado.php');
				}else{
					require('vistas/error.php');
				}
				break;


			case 'baja':
					//Validar datos

					if(  !isset($_GET['codigo'])  ){
						$error='no se recibio codigo';
						require('vistas/error.php');
					}
					$codigo = $_GET['codigo'];

				
					//Ahora si le hablo al modelo
					$status = $this->modelo->baja($codigo);
					if( $status ){
						require('vistas/alumnoBorrado.php');
					}else{
						$error = 'Ocurrio un error al dar de baja';
						require('vistas/error.php');
					}

				break;


			case 'consulta':
					//Validar datos

					if(  !isset($_GET['codigo'])  ){
						$error='no se recibio codigo';
						require('vistas/error.php');
					}
					$codigo = $_GET['codigo'];

				
					//Ahora si le hablo al modelo
					$resultado = $this->modelo->consulta($codigo);
					if( $resultado ){
						require('vistas/alumnosConsulta.php');
					}else{
						$error = 'Ocurrio un error al consultar alumno';
						require('vistas/error.php');
					}


				break;


			default:
				$error='Alumno, Accion Incorrecta';
				require('vistas/error.php');
		}
	}
}
