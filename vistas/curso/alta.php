<?php
echo "Curso $nombre con fechas:<br/>";
foreach($diasCurso_Horas as $dia => $horas)
	echo $arre_diasem[date('w',$dia)],' ',date('d-m-Y',$dia),', ',$horas,' horas<br>';