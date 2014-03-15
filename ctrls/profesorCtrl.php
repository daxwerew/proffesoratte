<?php
require_once('ControladorComun.php');
class profesorCtrl extends ControladorComun{
	
	function ejecutar(){
		if( !isset($_GET['accion']) ){
			$error='no hay accion';
			require('vistas/error.php');
			die;
		}


		switch( $_GET['accion'] ){

			case 'alta':
				//Validar datos

					if( !isset($_GET['nombre']) || !isset($_GET['codigo']) ){
						$error='no se recibieron datos completos para dar de alta';
						require('vistas/error.php');
					}
					$nombre = $_GET['nombre'];
					$codigo = $_GET['codigo'];

					//Nombre
					if( !preg_match("/^[a-z| ]+$/i",$nombre) ){
						$error='nombre de alumno no convencional';
						require('vistas/error.php');
						die;
					}

				
				//Ahora si le hablo al modelo
				$status = $this->modelo->alta($nombre,$codigo);
				if( $status ){
					//Cargo vista de bien hecho
					require('vistas/profesor/insertado.php');
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
						require('vistas/profesor/borrado.php');
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
					$status = $this->modelo->consulta($codigo);
					if( $status ){
						require('vistas/profesor/consulta.php');
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
