<?php
class ModeloComun{
	public $mysqli;

	function __construct(){

		require('/../db.inc.php');
		
		$this->mysqli = new mysqli($db_site, $db_user, $db_pass, $db_schema);
		if ( $this->mysqli->connect_error) {
		    die('Error de Conexión (' . $this->mysqli->connect_errno . ') '
		            . $this->mysqli->connect_error);
		}

	}


}
