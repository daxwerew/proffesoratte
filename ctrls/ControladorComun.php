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


		/*/Temporal Patch willbe removed after GUI is done
		if(  (!isset($_POST) || count($_POST)<1) AND $_GET['ctrl']!='login'  ){
			require( "vistas/temporal.php");die;
		}
	    //Temporal Patch End*/
	}

	/**
	 * @author Diego Ruiz Jiménez
	 * @param $_VARS array to be searched
	 * @param $expected_data the INDEX should be the name to search in $_VARS, and VALUE the expression it must MATCH
	 */
	function validateVars( array $_VARS, array $expected_data )
	{
		
		$respuesta = array();
		$errores = array();
		foreach($expected_data as $expected_var => $regex )
		{

			if(   !array_key_exists( $expected_var, $_VARS ) ){
				$errores['repetirErrores'][] =
					array(
						'dato'  => $expected_var,
						'error' => 'No se recibio'
					);
			}
			elseif( is_array( $_VARS[$expected_var]) ){
				//Si es un arreglo valido dato por dato con la misma expresion, soy bien inteligentote
				foreach( $_VARS[$expected_var]  as $valorDentroDeArreglo)
					if(!preg_match( $regex, $valorDentroDeArreglo )){
						$errores['repetirErrores'][]=array('dato'=>$expected_var,'error' =>"con valor $valorDentroDeArreglo no es valido");
					}
			}
			elseif(   !preg_match( $regex, $_VARS[$expected_var] ) ){
				$errores['repetirErrores'][]=array('dato'=>$expected_var,'error'=>'No valido');
			}
			else
				$respuesta[$expected_var] = $_VARS[$expected_var];

		}


		if( count($errores)>0 ){
			$errores['paginaAtras'] = $_SERVER['REQUEST_URI'];
			$this->generaPaginaDesdePlantila('errorValidacion.html', $errores );
			die;
		}

		$respuesta[0]=true;
		return $respuesta;


	}


	static function generaPaginaDesdePlantila($nombre_plantilla, $diccionario)
	{

		$pagina = file_get_contents("public/{$nombre_plantilla}");

		//Busca zonas a repetir
		foreach ($diccionario as $key => $value) {
			if( substr($key,0,7)=='repetir' && is_array($value) ){

				$posinicio = strpos($pagina, "<!--<<$key>>-->");
				$posfin = strpos($pagina, "<!--<<finrepetir>>-->",$posinicio);
				$posfin = $posfin+strlen("<!--<<finrepetir>>-->");
				$length_reemplazo = $posfin-$posinicio;
				$texto_a_repetir = substr($pagina, $posinicio, $length_reemplazo);

				$texto_remplazo='';
				foreach($value as $diccionarioInterno){
					
					if( is_array($diccionarioInterno) ){
						$diccionarioInterno = ControladorComun::despulgarDiccionario($diccionarioInterno);
						$texto_remplazo .=strtr($texto_a_repetir,$diccionarioInterno);
					}

				}

				$pagina = substr_replace($pagina,$texto_remplazo,$posinicio,$posfin-$posinicio);

				unset($diccionario[$key]);
			}
		}
		$diccionario = ControladorComun::despulgarDiccionario($diccionario);

		$pagina = strtr($pagina,$diccionario);

		echo file_get_contents("public/header.html"), $pagina, file_get_contents("public/footer.html");
		die;
	}

	//modifica los indices del diccionario con el sig formato <!--<$key>-->
	static function despulgarDiccionario( $diccionario ){
		if( is_array( $diccionario ) )
			foreach( $diccionario as $key => $value ){
				$diccionario["<!--<$key>-->"]=$value;
				unset($diccionario[$key]);
			}

		return $diccionario;
	}

	static function errorComun( $mensajeError ){
		$diccionario =
			array(
				'error'       => $mensajeError,
				'paginaAtras' => $_SERVER['REQUEST_URI']
			);
		ControladorComun::generaPaginaDesdePlantila('errorComun.html', $diccionario );
		die;
	}

	function exitoGenerico( $mensaje ){
		$diccionario = array( 'mensaje' => $mensaje );
		$this->generaPaginaDesdePlantila('exitoGenerico.html', $diccionario );
		die;
	}

}
