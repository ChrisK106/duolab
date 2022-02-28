$(document).on('submit', '#login-form', function(event){

	event.preventDefault();

	$.ajax({
		url: 'modules/login.php',
		type: 'POST',
		dataType: 'json',
		data: $(this).serialize(),
		beforeSend: function(){
			$('#btnLogin').val('Validando...');
		}
	})
	.done(function(response){
		if(response.error == null){
			console.log(response);
			toastr.error(response,'Error desconocido');
			return;
		}
		if(!response.error){
			location.href = 'views/home';
		}else{
			toastr.error('Las credenciales que ha ingresado no son válidas','Acceso Denegado');
			$('#btnLogin').val('Ingresar');
		}		
	})
	.fail(function(response){
		console.log(response.responseText);
		toastr.error(response.responseText,'Error de respuesta del servidor');
	})
	.always(function(){
		//console.log('AJAX call complete');
	});
});