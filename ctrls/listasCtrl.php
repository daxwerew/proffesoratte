<?php
class listasCtrl extends ControladorComun{
	
	function ejecutar(){
		if( !isset($_GET['accion']) ){
			$this->errorComun('listas, no hay accion');
			die;
		}


		switch( $_GET['accion'] ){
			case 'alta':
				//Validar datos
					if( empty($_POST) ){
						//Cargar Formulario
						$this->formularioAlta();
						die;
					}

					//Validar Variables recibidas
					$arregloVars = $this->validateVars(
						$_POST,
						array(
							'cicloEscolar' => '/^[0-9]{1,8}$/i',
							'curso'        => '/^[0-9]{1,8}$/i',
							'seccion'      => '/^[a-z][0-9]{2}$/i'
						)
					);

					extract($arregloVars);

				
				//Ahora si le hablo al modelo
				$status = $this->modelo->alta($cicloEscolar,$curso,$seccion);
				if( $status ){
					$this->generaPaginaDesdePlantila('exitoGenerico.html', array(
						'mensaje'=>"Se dio de alta Lista Exitosamente") );
				}else{
					$this->errorComun('Error en el modelo');
				}
				break;


			case 'altaAlumnos':
					if( empty($_POST) ){
						$diccionario['repetirListas' ] = $this->modelo->consultaLista()['repetirListas' ];
						$diccionario['repetirAlumnos'] = $this->modelo->consultaAlumnos()['repetirAlumnos'];
						if( isset($diccionario['repetirAlumnos'][0]['idAlumno']) ){
							$this->generaPaginaDesdePlantila('lista/altaAlumnos.html', $diccionario );
						}else{
							$this->errorComun('Error en logica de negocio');
							die;
						}
					}

					//Validar Variables recibidas
					foreach( $_POST['alumnos'] as $alumno )
						if( !preg_match( '/^[0-9]{1,8}$/i', $alumno) )
							$this->generaPaginaDesdePlantila('errorValidacion.html', array(
								'dato'  => "Alumno $alumno", 
								'error' => 'No valido'
								)
							);
					$alumnos = $_POST['alumnos'];
					unset($_POST['alumnos']);

					extract($this->validateVars(
						$_POST,
						array(
							'lista'   => '/^[0-9]{1,8}$/i'
						)
					));

					//Valida si existe evaluaciones
					$respuesta = $this->modelo->tieneEvaluacion($lista);
					if( $respuesta===false){
						$this->errorComun('No existen evaluaciones');
					}
					elseif($respuesta!==true){
						$this->errorComun($respuesta);
					}

				//Ahora si le hablo al modelo
				$status = $this->modelo->altaAlumnos($lista,$alumnos);
				if( $status ){
					$this->generaPaginaDesdePlantila('exitoGenerico.html', array(
						'mensaje'=>"Se dio de alta Alumnos en esta Lista Exitosamente") );
				}else{
					$this->errorComun('Error en el modelo');
				}

				break;
			case 'consulta':
					//Validations
					if( empty($_GET['idLista']) ){
						$diccionario = $this->modelo->consultaLista();
						if( !$diccionario['error'] ){
							$this->generaPaginaDesdePlantila('lista/consulta1.html', $diccionario );
						}else{
							$this->errorComun($diccionario['mensaje']);
						}
					}

					$arregloVars = $this->validateVars($_GET,array(
						'idLista'     => '/^[0-9]{1,10}$/i'
					));
					extract($arregloVars);

					//Model
					$diccionario = $this->modelo->consultaAlumnosLista($idLista);
					if( !$diccionario['error'] ){
						$this->generaPaginaDesdePlantila('lista/consulta2.html', $diccionario );

					}else{
						$this->errorComun($diccionario['mensaje']);
						die;
					}


				break;


			default:
				$this->errorComun('lista, Accion Incorrecta');
		}
	}

	function formularioAlta(){

		$diccionario = $this->modelo->generaDiccionarioAltaLista();
		$diccionario['accion']='alta';
		$this->generaPaginaDesdePlantila('lista/formularioLista.html', $diccionario );
		die;
	}
}
