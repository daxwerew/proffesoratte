<?php

	session_start();

	//Default Values
	$get_ctrl  = (isset($_GET['ctrl']))?$_GET['ctrl']:'alumnos';
	$get_accion = (isset($_GET['accion']))?$_GET['accion']:'consulta';

	//Logged in?
	$_SESSION['usu']=true;//parche para no validar login
	if( isset($_SESSION['usu']) ){

		/*/Verify Permissions
		if( !isset(  $_SESSION['usu'][$get_ctrl][$get_accion])&& $get_ctrl!='login' ){
			$error="No tienes permiso para $get_accion en $get_ctrl";
			require('vistas/error.php');
		}//*/

		//Getting Controller Name
		$controlador = "{$get_ctrl}Ctrl";

		if(  !file_exists("ctrls/{$controlador}.php")  ){
			$error="$get_ctrl no es un controlador valido";
			require('vistas/error.php');
		}

		require("ctrls/{$controlador}.php");
		$ctrl = new $controlador();


	}else{

		//Storing QueryString, to redirect to it after loging in
		if( !isset($_SESSION['old_query_string']) AND  $get_ctrl!='login' ) 
			$_SESSION['old_query_string'] = $_SERVER['QUERY_STRING'];
		
		//Not logged huh?, then controller=login and accion=in
		$_GET['accion'] = 'in';
		require("ctrls/loginCtrl.php");
		$ctrl = new loginCtrl();

	}
	
	$ctrl->ejecutar();
	
