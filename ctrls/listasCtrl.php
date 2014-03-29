<?php
require_once('ControladorComun.php');
class listasCtrl extends ControladorComun{
	
	function ejecutar(){
		if( !isset($_GET['accion']) ){
			$error='listas, no hay accion';
			require('vistas/error.php');
			die;
		}


		switch( $_GET['accion'] ){

			case 'alta':
				//Validar datos

				if( !isset($_GET['alumnos']) || !isset($_GET['curso']) ||
						!isset($_GET['cicloEscolar'])  ){
					$error='no se recibieron datos completos para dar de alta un lista';
					require('vistas/error.php');
				}
				$alumnos = $_GET['alumnos'];
				$curso = $_GET['curso'];
				$cicloEscolar = $_GET['cicloEscolar'];

				if(!is_array($alumnos)){
					$error='alumnos deberia ser arreglo';
					require('vistas/error.php');
				}

				
				//Ahora si le hablo al modelo
				$status = $this->modelo->alta($alumnos,$curso,$cicloEscolar);
				if( $status ){
					//Cargo vista de bien hecho
					require('vistas/listas/consulta.php');
				}else{
					require('vistas/error.php');
				}
				break;


			case 'baja':
					//Validar datos
					if(  !isset($_GET['lista'])  ){
						$error='no se recibio lista';
						require('vistas/error.php');
					}
					$lista = $_GET['lista'];

				
					//Ahora si le hablo al modelo
					$status = $this->modelo->baja($lista);
					if( $status ){
						require('vistas/listasViews/listaBorrada.php');
					}else{
						$error = 'Ocurrio un error al dar de baja';
						require('vistas/error.php');
					}

				break;


			case 'consultar':
					//Validar datos

					if(  !isset($_GET['lista'])  ){
						$error='no se recibio lista';
						require('vistas/error.php');
					}
					$lista = $_GET['lista'];

				
					//Ahora si le hablo al modelo
					$status = $this->modelo->consulta($lista);
					if( $status ){
						require('vistas/listasViews/listaConsulta.php');
					}else{
						$error = 'Ocurrio un error al consultar lista';
						require('vistas/error.php');
					}
				break;


			case 'modificar':
				//Validar datos

					if( !isset($_GET['alumnos']) || !isset($_GET['curso']) ||
							!isset($_GET['cicloEscolar']) || !isset($_GET['lista']) ){
						$error='no se recibieron datos completos para modificar una lista';
						require('vistas/error.php');
					}
					$alumnos = $_GET['alumnos'];
					$curso = $_GET['curso'];
					$cicloEscolar = $_GET['cicloEscolar'];
					$lista = $_GET['lista'];

				
				//Ahora si le hablo al modelo
				$status = $this->modelo->modificar($alumnos,$curso,$cicloEscolar,$lista);
				if( $status ){
					//Cargo vista de bien hecho
					require('vistas/listasViews/listaConsulta.php');
				}else{
					require('vistas/error.php');
				}
				break;


			default:
				$error='lista, Accion Incorrecta';
				require('vistas/error.php');
		}
	}
}
