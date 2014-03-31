<html>
<script src="../../jquery-2.1.0.js"></script>
<script>
$(document).ready(function(){


	$("#btnMas").click(function(){
		
		//Validating Data
		if(  !$("#numRubros").val() || !$("#nomEval").val() ){
			alert('Llena los campos');
			return false;
		}

		var numRubros = $("#numRubros").val();
		var nomEval = $("#nomEval").val();
		//VALIDACION PEPE numRubros debe ser numerico sino es alert('error');return false;

		//Copying values
		$("#divEval").prepend('<br>');

		$("<input type='text' name='rubros[]' readonly >")
		.val(numRubros)
		.prependTo("#divEval");
		
		$("<input type='text' name='eval[]' readonly >")
		.val(nomEval)
		.prependTo("#divEval");

		//empty fields
		$("#nomEval").val('');
		$("#numRubros").val('');

	});

});
</script>
<body>
	<form action='index.php?ctrl=curso&accion=alta&cicloEscolar=2014A&nombre=Compiladores&seccion=CC100-D02&academia=COM&nrc=80321&diasSemana_Horas[1]=3&diasSemana_Horas[5]=4&fechaInicio=14/02/2014&fechaFinal=20/07/2014' method='POST'>
		Evaluaci&oacute;n
		<br/>
		Nombre evaluacion&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cantidad Rubros
		<div id='divEval'>
			<input id='nomEval'>
			<input id='numRubros'>
			<input id="btnMas" type='button' value='M&aacute;s'>
		</div>

		<input type='submit' value='Crear Curso'>
	</form>
</body>
</html>