<?php
class ControladorComun{
	
	public $modelo;

	function __construct(){
		$mdlNombre = substr(get_class($this),0,-4).'Mdl';

		if( file_exists("mdls/{$mdlNombre}.php") ){
			require("mdls/{$mdlNombre}.php");
			$this->modelo = new $mdlNombre();
		}else{
			//$error="No hay modelo {$mdlNombre}.php";
			//require('vistas/error.php');
		}


		//Temporal Patch willbe removed after GUI is done
		if(  (!isset($_POST) || count($_POST)<1) AND $_GET['ctrl']!='login'  ){
			require( "vistas/temporal.php");die;
		}
	    //Temporal Patch End
	}

	/**
	 * @author Diego Ruiz Jiménez
	 * @param $_VARS array to be searched
	 * @param $expected_data the INDEX should be the name to search in $_VARS, and VALUE the expression it must MATCH
	 */
	function validateVars( array $_VARS, array $expected_data )
	{
		
		$respuesta = array();
		foreach($expected_data as $expected_var => $regex )
		{

			if(   !array_key_exists( $expected_var, $_VARS )   )
			{
				return array(false, $expected_var, 'No existe');
			}

			if(   !preg_match( $regex, $_VARS[$expected_var] )   )
			{
				return array(false, $expected_var, 'No cumple');
			}
			$respuesta[$expected_var] = $_VARS[$expected_var];

		}

		$respuesta[0]=true;
		return $respuesta;


	}




}
