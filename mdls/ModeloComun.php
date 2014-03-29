<?php
class ModeloComun{
	public $DB;

	function __construct(){

		require('/../db.inc.php');
		
		$this->DB = new mysqli($db_site, $db_user, $db_pass, $db_schema);
		if ( $this->DB->connect_error) {
		    die('Error de Conexión (' . $mysqli->connect_errno . ') '
		            . $mysqli->connect_error);
		}

	}


}
