<?php
class evaluacionCtrl extends ControladorComun{

	function ejecutar(){
		if( !isset($_GET['accion']) ){
			$error='no hay accion';
			require('vistas/error.php');
		}

		switch( $_GET['accion'] ){
			case 'alta':

				if( empty($_POST) ){
					//Cargar Formulario
					$diccionario = $this->modelo->consultaListas();
					$this->generaPaginaDesdePlantila('evaluacion/formulario.html', $diccionario );
					die;
				}

				//Validar Variables recibidas
				//'/^([a-z]{2}\d{3}|[a-z]?\d{4})-[a-z]\d{2}$/i'
				$arregloVars = $this->validateVars(
					$_POST,
					array(
						'lista'            => '/^[0-9]{1,8}$/i',
						'nombreEvaluacion' => '/^[a-z0-9 ]+$/i',
						'porcentaje'       => '/^([0-9]{1,2}|100)$/i',
					)
				);
				extract($arregloVars);
				$nombreEvaluacion = $_POST['nombreEvaluacion'];
				$porcentaje       = $_POST['porcentaje'];

				$estatus = $this->modelo->alta($lista,$nombreEvaluacion,$porcentaje);
				if( $estatus ){
					$this->exitoGenerico('Se creo evaluacion para el grupo Exitosamente');
				}else{
					$this->errorComun('modelo no pudo crear evaluaciones');
				}
				break;


				
			default:
				$error='accion incorrecta';
				require('vistas/error.php');
		}
	}
}
