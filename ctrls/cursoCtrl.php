<?php
require_once('ControladorComun.php');
class cursoCtrl extends ControladorComun{

	function ejecutar(){
		if( !isset($_GET['accion']) ){
			$error='no hay accion';
			require('vistas/error.php');
		}

		switch( $_GET['accion'] ){
			case 'alta':

					if( empty($_POST) ){
						//Cargar Formulario
						$diccionario["accion"   ] = 'alta';
						$diccionario["clave"   ] = '';
						$diccionario["nombre"   ] = '';
						$diccionario["departamento"  ] = '';

						$this->generaPaginaDesdePlantila('curso/formulario.html', $diccionario );
						die;
					}

					//Validar Variables recibidas
					//'/^([a-z]{2}\d{3}|[a-z]?\d{4})-[a-z]\d{2}$/i'
					$arregloVars = $this->validateVars(
						$_POST,
						array(
							'clave'     => '/^([a-z]{2}\d{3}|[a-z]?\d{4})$/i',
							'nombre'     => '/^[a-z| ]+$/i',
							'departamento'    => '/^([a-z| ]+| *)$/i'
						)
					);
					extract($arregloVars);


				/*
				if( count($_POST)==0 ){
					require('vistas/curso/altaFormu.php');
					die;
				}

				$_VAR = $_GET;
				//Validating
				//Datos requeridos Nombre, Seccion, NRC, opcionales, academia, dias clase, horas por dia
				//nombre=a&seccion=D05&nrc=2&evaluacion[]=&dia_sem[]=1&dia_sem[]=3&fec_ini=25/02/2014&fec_fin=30/6/2014
				if( !isset($_VAR['cicloEscolar']) || !isset($_VAR['nombre']) 
						|| !isset($_VAR['seccion']) || !isset($_VAR['academia']) 
						|| !isset($_VAR['nrc'])|| !isset($_VAR['diasSemana_Horas'])
						|| !isset($_VAR['fechaInicio'])|| !isset($_VAR['fechaFinal'])
				){
					$error='no se indicaron datos suficientes';
					require('vistas/error.php');
				}

				$seccion 		= $_VAR['seccion'];
				$cicloEscolar 	= $_VAR['cicloEscolar'];
				$nombre 		= $_VAR['nombre'];
				$academia  		= $_VAR['academia'];
				$nrc  			= $_VAR['nrc'];
				$diasSemana_Horas = $_VAR['diasSemana_Horas'];
				$fechaInicio = $_VAR['fechaInicio'];
				$fechaFinal = $_VAR['fechaFinal'];
				$evaluacion = isset($_POST['eval'])?$_POST['eval']:array();
				$rubros = isset($_POST['rubros'])?$_POST['rubros']:array();


				//seccion CC100-D02
				if( !preg_match("/^([a-z]{2}\d{3}|[a-z]?\d{4})-[a-z]\d{2}$/i",$_VAR['seccion']) )
				{
					$error='seccion incorrecta';
					require('vistas/error.php');
				}

				//Calcula dias validos entre fechaInicio y fechaFin con  diasSemana dados
				//Se creara arreglo $diasCurso
				$diasCurso_Horas=array();

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
					if( array_key_exists(date('w',$dia_ini),$diasSemana_Horas) ){
						$diasCurso_Horas[$dia_ini]=$diasSemana_Horas[date('w',$dia_ini)];
					}
					$dia_ini += $un_dia;
				}
				*/

				$estatus = $this->modelo->alta($clave,$nombre,$departamento);
				if( $estatus ){
					$this->exitoGenerico('Se creo Curso Exitosamente');
				}else{
					$this->errorComun('modelo no pudo crear Curso');
				}
				break;

			case 'baja':
				//Validar datos
				//Datos requeridos
					extract( $this->validateVars($_POST,array(
						'clave'     => '/^([a-z]{2}[0-9]{3}|[a-z]?[0-9]{4})$/i'
					)));
					//Llamada al modelo	
					$estatus = $this->modelo->baja($clave);
					//Carga vista dependiendo de la respuesta del modelo
					if( !$estatus['error'] ){
						$this->exitoGenerico("Se dio de baja Curso {$clave} Exitosamente");
					}else{
						$this->errorComun($estatus['mensaje']);
					}
				break;



			case 'consulta':
				//Validar datos
				//Datos requeridos
					extract( $this->validateVars($_GET,array(
						'clave'     => '/^([a-z]{2}[0-9]{3}|[a-z]?[0-9]{4})$/i'
					)));

					//Model
					$datos = $this->modelo->consulta($clave);
					if( !$datos['error'] ){
						$this->generaPaginaDesdePlantila('curso/consulta.html', $datos );

					}
					else{
						$this->errorComun($datos['mensaje']);
						die;
					}
				break;


				
			default:
				$error='accion incorrecta';
				require('vistas/error.php');
		}
	}
}
