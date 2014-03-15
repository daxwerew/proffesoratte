<?php
	echo "Insertado ciclo escolar con dias:<br/>";
	foreach($fechasCiclo as $dia)
		echo $arre_diasem[date('w',$dia)],' ',date('d-m-Y',$dia),'<br>';