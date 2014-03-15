<?php
	if( isset($_GET['ctrl']) ){

		//Carga ctrl Correspondiente
		$controlador = "{$_GET['ctrl']}Ctrl";

		if(file_exists("ctrls/{$controlador}.php")){
			require("ctrls/{$controlador}.php");
			$ctrl = new $controlador();

		}else{
			$error="{$_GET['ctrl']} no es un controlador valido";
			require('vistas/error.php');
		}

	}else{
		//ctrl default
		require('ctrls/alumnosCtrl.php');
		$ctrl = new alumnosCtrl();
		
	}
	
	$ctrl->ejecutar();
	
