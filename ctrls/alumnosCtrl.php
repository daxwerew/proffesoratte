<?php
require_once('ControladorComun.php');
class alumnosCtrl extends ControladorComun{
	
	function ejecutar(){
		if( !isset($_GET['accion']) ){
			$error='Alumnos, no hay accion';
			require('vistas/error.php');
		}


		switch( $_GET['accion'] ){

			case 'alta':


					if( empty($_POST) ){
						//Cargar Formulario
						$this->formularioAlta();
						die;
					}

					//Validar Variables recibidas
					$arregloVars = $this->validateVars(
						$_POST,
						array(
							'codigo'     => '/^[A-Z0-9]{7,9}$/i',
							'nombre'     => '/^[a-z| ]+$/i',
							'paterno'    => '/^[a-z| ]+$/i',
							'materno'    => '/^[a-z| ]+$/i',
							'carrera'    => '/^[0-9]+$/i',
							'email'      => '/^([A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}| *)$/i',//opcional,
							'github'     => '/^([A-Z0-9_]{2,4}| *)$/i'//mejorar regex
						)
					);

					extract($arregloVars);

					//Model Call
					$status = $this->modelo->alta(
							$codigo,
							$nombre,
							$paterno,
							$materno,
							$carrera,
							$email,
							$github
						);
					if( $status ){
						$this->generaPaginaDesdePlantila('exitoGenerico.html', array(
							'mensaje'=>"Se dio de alta Alumno Exitosamente") );
					}else{
						$this->errorComun('Error en el modelo de alta alumnos');
					}
					break;

			case 'baja':
					//Validations
					extract(
						$this->validateVars($_POST,array(
							'codigo'     => '/^[A-Z0-9]{7,9}$/i'
						))
					);

				
					$status = $this->modelo->baja($codigo);
					if( $status ){
						$this->generaPaginaDesdePlantila('exitoGenerico.html', array(
							'mensaje'=>"Se dio de baja Alumno con código {$codigo}"
						));
					}else{
						$this->errorComun('Ocurrio un error al dar de baja');
					}

				break;


			case 'consulta':
					//Validations
					$arregloVars = $this->validateVars($_GET,array(
						'codigo'     => '/^[A-Z0-9]{7,9}$/i'
					));
					extract($arregloVars);

					//Model
					$datosAlumno = $this->modelo->consulta($codigo);
					if( !$datosAlumno['error'] ){
						$this->generaPaginaDesdePlantila('alumno/consulta.html', $datosAlumno );

					}else{
						$this->errorComun($datosAlumno['mensaje']);
						die;
					}


				break;
			case 'modificar':
				//Validations
				if( !isset($_POST['codigo']) ){
					$this->errorComun('No se recibieron datos');
					die;
				}elseif( !isset($_POST['nombre']) ){
					$this->formularioModificar($_POST['codigo']);
					die;
				}

				$arregloVars = $this->validateVars($_POST,array(
					'codigo'     => '/^[A-Z0-9]{7,9}$/i',
					'nombre'     => '/^[a-z| ]+$/i',
					'paterno'    => '/^[a-z| ]+$/i',
					'materno'    => '/^[a-z| ]+$/i',
					'carrera'    => '/^[0-9]+$/i',
					'email'      => '/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i',
					'telefono'   => '/^([0-9]{6,14}| *)$/i',
					'github'     => '/^(.+| *)$/i',//mejorar regex
					'website'    => '/^(.+| *)$/i'//mejorar regex
				));
				extract($arregloVars);

				//Model
				$resultado = $this->modelo->modificar(
									$codigo,$nombre,$paterno,
									$materno,$carrera,$email,
									$telefono, $github, $website);
				if( $resultado ){
					$this->generaPaginaDesdePlantila('exitoGenerico.html', array(
						'mensaje'=>"Se modifico alumno con {$codigo}"
					));
				}else{
					$this->errorComun('Error en el modelo de modificar alumnos');
				}
				break;


			default:
				$this->errorComun('Alumno, Accion Incorrecta');
		}
	}

	function formularioAlta(){

		$diccionario["repetirCarrera"] = $this->modelo->generaDiccionarioCarreras();
		$diccionario["accion"   ] = 'alta';
		$diccionario["codigo"   ] = '';
		$diccionario["nombre"   ] = '';
		$diccionario["paterno"  ] = '';
		$diccionario["materno"  ] = '';
		$diccionario["email"    ] = '';
		$diccionario["telefono" ] = '';
		$diccionario["github"   ] = '';

		$this->generaPaginaDesdePlantila('alumno/formulario.html', $diccionario );
		die;
	}

	function formularioModificar($codigo){
		$diccionario = $this->modelo->consulta($codigo);
		if( $diccionario['error'] ){
			$this->generaPaginaDesdePlantila('errorComun.html', array(
				'error'       => $diccionario['mensaje'],
				'paginaAtras' => $_SERVER['REQUEST_URI']
			) );
		}
		$diccionario["accion"   ] = 'modificar';
		$diccionario["repetirCarrera"] = $this->modelo->generaDiccionarioCarreras();

		$this->generaPaginaDesdePlantila('alumno/formulario.html', $diccionario );
		die;
	}

}
