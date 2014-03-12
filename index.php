<?php
	if( isset($_GET['controlador']) ){
		//Carga Controlador Correspondiente
		switch( $_GET['controlador'] ){

			case 'alumno':
				require('ctrls/alumnosCtrl.php');
				$controlador = new alumnosCtrl();
				break;

			case 'profesor':
				require('ctrls/profesorCtrl.php');
				$controlador = new alumnosCtrl();
				break;

			case 'grupo':
				require('ctrls/grupoCtrl.php');
				$controlador = new grupoCtrl();
				break;

			case 'ciclo_escolar':
				require('ctrls/cicloEscolarCtrl.php');
				$controlador = new alumnosCtrl();
				break;

			case 'calificaciones':
				require('ctrls/calificacionCtrl.php');
				$controlador = new alumnosCtrl();
				break;

			default:
				$error='controlador incorrecto';
				require('vistas/error.php');
				die;
		}
	}else{
		//Controlador default
		require('ctrls/alumnosCtrl.php');
		$controlador = new alumnosCtrl();
		
	}
	
	$controlador->ejecutar();
	
