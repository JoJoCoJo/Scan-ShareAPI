
var root = 'http://scan-share.api/';

$(document).ready(function(){

	$('#formLogin').submit(function(e){

		var params = {"email": $('#emailLogin').val(), "password":  $('#passwordLogin').val()};

		$.ajax({

			url: root + 'api/usuarios/auth/',
			type: 'POST',
			dataType: 'JSON',
			data: params,
			beforeSend: function(){
				swal({
				  title: 'Procesando, por favor espere...',        
				  html: '<div class="progress"><div class="indeterminate blue"></div></div>'
				});
			},
			success: function(response){
				$.each(response, function(result, element){
					//console.log(response);
					swal({
					  title: '¡Bienvenido ' +element.data.name+' '+element.data.lastname+'!',
					  text: element.message,
					  type: 'success',
					  showConfirmButton: false,
					  showCancelButton: true,
					  timer: 1500
					}).then(
					  function () {},
					  // handling the promise rejection
					  function (dismiss) {
					    if (dismiss === 'timer') {
					      
					      window.location.replace(root + "views/menuView.php");
						  
					    }
					  }
					)

				});
			},
			 error: function (XMLHttpRequest, textStatus, errorThrown) {
			 	// console.log('Error params:');
			 	// console.log(params);
			 	$.each(XMLHttpRequest.responseJSON, function(result, element){
			 		swal('Algo salío mal.', element.message.toString(), 'error');	
			 	});
                console.error('Error: '+ textStatus, errorThrown);
                
            }
		});
		
		return false;
	});

});
	