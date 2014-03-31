<html>
	<body>
		<?php
			echo "Bienvenido de nuevo {$_SESSION['usu']['nombre_completo']}",
					"<br><br>Temporalmente se muestran permisos<br><pre>";
			var_dump($_SESSION);
			echo "</pre>";
		?>
	</body>
</html>
