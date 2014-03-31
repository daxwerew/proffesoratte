<!--?php var_dump($_SERVER);die;?-->
<body>
<script src="../../jquery-2.1.0.js"></script>
<script>
	$(document).ready(function(){		
		$("#enviar").click(function(){
			$.post($('#url').val(),$('#post').val(),function(data){
				$('body').html(data);
			})
		})
	})
</script>
<div id='respuesta'></div>
INTERFAZ TEMPORAL, sera borrada al crear entorno grafico correcto
<form style='margin:0px auto;width:70%;border:1px solid;padding:100px 20px;'>
<label for='url'>URL STRING: </label>
<input 
	id='url' 
	name='url' 
	value='<?php echo $_SERVER['REQUEST_URI']; ?>' 
	style='width:80%;'
/>
<br>
<br>
<label for='post'>POST DATA: </label>
<input id='post' name='post' style='width:80%' />
<br>
<br>
<input 
	id='enviar' 
	type='button' 
	value='Enviar' 
	style='display:block;margin:0px auto;height:100px;width:200px;' 
/>
</form>	
</body>