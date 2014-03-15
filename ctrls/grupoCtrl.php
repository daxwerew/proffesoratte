<?php
class grupoCtrl{
	public $modelo;
	function __construct(){
		//Definimos el modelo
		require('mdls/grupoMdl.php');
		$this->modelo = new grupoMdl();
	}

	function ejecutar(){
		if( !isset($_GET['accion']) ){
			$error='no hay accion';
			require('vistas/error.php');
			die;
		}

		switch( $_GET['accion'] ){
			case 'alta':
				$_VAR = $_GET;
				//Validar datos
				//Datos requeridos Nombre, Seccion, NRC, opcionales, academia, dias clase, horas por dia
				//nombre=a&seccion=D05&nrc=2&evaluacion[]=&dia_sem[]=1&dia_sem[]=3&fec_ini=25/02/2014&fec_fin=30/6/2014
				if( !isset($_VAR['nombre']) || !isset($_VAR['seccion']) ||
						!isset($_VAR['nrc']) || !isset($_VAR['evaluacion']) ||
						!isset($_VAR['dia_sem']) || !isset($_VAR['fec_ini']) ||
						!isset($_VAR['fec_fin'])
						){
					$error='no se indicaron datos suficientes';
					require('vistas/error.php');
					die;
				}

				$nombre = $_VAR['nombre'];
				$nrc  = $_VAR['nrc'];
				$seccion = $_VAR['seccion'];
				$evaluacion = $_VAR['evaluacion'];

				$dia_sem = $_VAR['dia_sem'];
				$fec_ini = $_VAR['fec_ini'];
				$fec_fin = $_VAR['fec_fin'];


				//seccion
				if( !preg_match("/^([a-z]{2}\d{3}|[a-z]?\d{4})-[a-z]\d{2}$/i",$_VAR['seccion']) ){
					$error='seccion incorrecta';
					require('vistas/error.php');
					die;
				}

				//evaluacion
				/*if( is_array($evaluacion) ){
					$error='evaluacion debe ser un arreglo de conceptos con su porcentaje';
					require('vistas/error.php');
					die;
				}*/

				//dias semana
				if( !is_array($dia_sem) ){
					$error='Dias semana debe ser arreglo';
					require('vistas/error.php');
					die;
				}

				foreach($dia_sem as $dsem ){
					if( $dsem<1 && $dsem>6){
						$error = 'Rango de días incorrecto';
						require('vistas/error.php');
						die;
					}
				}

				//fechas
				$fec_ini1 = explode("/",$fec_ini);
				if( !checkdate($fec_ini1[1],$fec_ini1[0],$fec_ini1[2]) ){
						$error = 'Fecha inicio no valida '.$fec_ini;
						require('vistas/error.php');
						die;
				}
				$fec_fin2 = explode("/",$fec_fin);
				if( !checkdate($fec_fin2[1],$fec_fin2[0],$fec_fin2[2]) ){
						$error = 'Fecha fin no valida';
						require('vistas/error.php');
						die;
				}

				$arre_diasem=array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes');

				$un_dia = 86400;
				$dia_ini = mktime(0,0,0,$fec_ini1[1],$fec_ini1[0],$fec_ini1[2]);
				$dia_fin = mktime(0,0,0,$fec_fin2[1],$fec_fin2[0],$fec_fin2[2])+$un_dia ;

				while( $dia_ini<$dia_fin ){
					if( in_array(date('w',$dia_ini),$dia_sem) )
						echo $arre_diasem[date('w',$dia_ini)],' ',date('d-m-Y',$dia_ini),'<br>';
					$dia_ini += $un_dia;
				}die;

				//Llamada al modelo	
				$estatus = $this->modelo->alta($nombre,$nrc,$seccion);
				//Carga vista dependiendo de la respuesta del modelo
				if( $estatus ){
					require('vistas/grupoAlta.php');
				}else{
					$error='falla interna Mdl';
					require('vistas/error.php');
				}
				break;
			case 'consulta':
				//Validar datos
				//Datos requeridos
				if( !isset($_GET['seccion']) ){
					$error='no se indico grupo';
					require('vistas/error.php');
					die;
				}
				if( !preg_match("/^([a-z]{2}\d{3}|[a-z]?\d{4})-[a-z]\d{2}$/i",$_GET['seccion']) ){
					$error='grupo incorrecta';
					require('vistas/error.php');
					die;
				}
				//Datos opcionales
				if( !isset($_GET['orden'])){
					$_GET['orden']='';
				}


				//Llamada al modelo	
				$listaAlumnos = $this->modelo->listaEstudiantes($_GET['seccion'],$_GET['orden']);
				//Carga vista dependiendo de la respuesta del modelo
				if( is_array($listaAlumnos) ){
					require('vistas/grupoLista.php');
				}else{
					$error='falla interna';
					require('vistas/error.php');
				}
				break;
			default:
				$error='accion incorrecta';
				require('vistas/error.php');
		}
	}
}
