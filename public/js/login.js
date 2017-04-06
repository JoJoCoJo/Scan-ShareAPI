
var root = 'http://scan-share.api/';

$(document).ready(function(){

	$('#formLogin').submit(function(e){
		var params = {"email": $('#emailLogin').val(), "password":  $('#passwordLogin').val()};
		// console.log('Submit params:');
		// console.log(params);

		$.ajax({

			url: root + 'api/usuarios/auth/',
			type: 'POST',
			dataType: 'JSON',
			data: params,
			beforeSend: function(){
				swal('Procesando, por favor espere...');
			},
			success: function(response){
				$.each(response, function(result, element){

					swal({
					  title: '¡Bienvenido ' +element.data.name+' '+element.data.lastname+'!',
					  text: 'Te estamos redirigiendo al menú :D',
					  type: 'success',
					  showConfirmButton: false,
					  showCancelButton: true,
					  timer: 3500
					}).then(
					  function () {},
					  // handling the promise rejection
					  function (dismiss) {
					    if (dismiss === 'timer') {
					      
					      sessionStorage.setItem('loginNombre', element.data.name);
					      sessionStorage.setItem('loginApellido', element.data.lastname);
					      sessionStorage.setItem('loginEmail', element.data.email);
					      sessionStorage.setItem('loginBirth', element.data.birthdate);
					      sessionStorage.setItem('loginRole', element.data.role_id);
					      window.location.replace(root + "views/menuView.php");
						  
					    }
					  }
					)

				});
			},
			 error: function (XMLHttpRequest, textStatus, errorThrown) {
			 	// console.log('Error params:');
			 	// console.log(params);
                console.error('Error: '+ textStatus, errorThrown);
                swal('Error', 'Usuario y/o Contraseña incorrectos', 'error');
            }
		});
		
		return false;
	});

});
	