<?php

$tabla="<table border=1><tr><th>Alumno</th></tr>";
foreach($listaAlumnos as $alumno){
	$tabla .= "<tr><td>$alumno</td></tr>";
}
echo "$tabla</table>";