<?php
require_once('ControladorComun.php');

class loginCtrl extends ControladorComun{
	
	function ejecutar(){

		if( !isset($_GET['accion']) ){
			$error='no hay accion';
			require('vistas/error.php');
			die;
		}

		switch( $_GET['accion'] ){
			case 'in':
				$this->loginin();
				break;

			case 'out':
				session_unset();
				session_destroy();
				setcookie(session_name(), '', -3600);
				break;
			default:
				$error='Accion Incorrecta';
				require('vistas/error.php');
		}

	}



	function loginin(){

		if( $this->estaLoggeado() ){
			require('vistas/login/home.php');

		}else if( count($_POST)>0 ){

			$logeoUsuario = $this->modelo->buscarUsuario($_POST['usu'],$_POST['pas']);
			if( $logeoUsuario ){
				$_SESSION['usu'] = $logeoUsuario;
				
				if( isset($_SESSION['old_query_string']) ){
					$old_query_string = $_SESSION['old_query_string'];
					unset($_SESSION['old_query_string']);
					header("Location: index.php?{$old_query_string}");
				}
				else{
					require('vistas/login/logeado.php');
				}

			}else{
				$error='login incorrecto, revisa codigo y password';
				require('vistas/error.php');
			}

		}
		else
		{
			header("Location: vistas/login/logme.php");
		}

	}



	function estaLoggeado(){
		if(isset($_SESSION['usu']))
			return true;
		return false;
	}
}
