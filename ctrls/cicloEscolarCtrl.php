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

					if( !isset($_GET['ciclo']) || !isset($_GET['fechaInicio']) ||
							!isset($_GET['fechaFinal']) ){
						$error='no se recibieron datos completos para dar de alta del ciclo';
						require('vistas/error.php');
						die;
					}

					$ciclo = $_GET['ciclo'];
					$fechaInicio = $_GET['fechaInicio'];
					$fechaFinal = $_GET['fechaFinal'];
					//$diasSemana = $_GET['diasSemana'];

					//ciclo
					if( !preg_match("/^2[0-9]{3}[ABV]$/i",$ciclo) ){
						$error='ciclo no valido';
						require('vistas/error.php');
					}

					//Calcula dias validos entre fechaInicio y fechaFin con  diasSemana dados
					//Se creara arreglo $fechasCiclo
					$fechasCiclo=array();

					$fec_ini1 = explode("/",$fechaInicio);
					if( !checkdate($fec_ini1[1],$fec_ini1[0],$fec_ini1[2]) ){
							$error = 'Fecha inicio no valida '.$fec_ini;
							require('vistas/error.php');
					}
					$fec_fin2 = explode("/",$fechaFinal);
					if( !checkdate($fec_fin2[1],$fec_fin2[0],$fec_fin2[2]) ){
							$error = 'Fecha fin no valida';
							require('vistas/error.php');
					}

					$arre_diasem=array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes');

					$un_dia = 86400;
					$dia_ini = mktime(0,0,0,$fec_ini1[1],$fec_ini1[0],$fec_ini1[2]);
					$dia_fin = mktime(0,0,0,$fec_fin2[1],$fec_fin2[0],$fec_fin2[2])+$un_dia ;

					while( $dia_ini<$dia_fin ){
						//if( in_array(date('w',$dia_ini),$diasSemana) ){
							$fechasCiclo[]=$dia_ini;
						//}
						$dia_ini += $un_dia;
					}
				
				//Ahora si le hablo al modelo
				$status = $this->modelo->alta($ciclo,$fechasCiclo);
				if( $status ){
					//Cargo vista de bien hecho
					require('vistas/cicloEscolar/insertado.php');
				}else{
					require('vistas/error.php');
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
