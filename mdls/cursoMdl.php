<?php
require_once('ModeloComun.php');
class cursoMdl extends ModeloComun{

	function alta($cicloEscolar,$nombre,$seccion,$academia,$nrc,$diasCurso_Horas,$evaluacion,$rubros){

		$consulta = "CREATE TABLE {$nombre}_{$evaluacion[0]}_{$rubros[0]}(
					ID INT AUTO_INCREMENT PRIMARY KEY,"; 
		for($i=0; $i<=$rubros[0];$i++){
			$consulta .= "col{$i} float,";
		}
		$consulta = substr($consulta, 0, -1) . ")engine=innodb";

		return $this->DB->query( $consulta );
	}
	


	function consulta($seccion){
		return true;
	}



}
