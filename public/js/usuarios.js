
    var root = 'http://scan-share.api/';
    var table;

$(document).ready(function(){

      $(".button-collapse").sideNav();
      $('.modal').modal({
        dismissible: false
      });
      $('.datepicker').pickadate({
      	container: 'body',
      	selectYears: 100,
      	monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      	monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dec'],
      	weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      	weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
      	weekdaysLetter: [ 'D', 'L', 'M', 'Mi', 'J', 'V', 'S' ],
      	firstDay: 1,
      	min: [1900,1,1],
      	max: true,
      	
      	// Buttons
      	today: 'Hoy',
      	clear: 'Limpiar',
      	close: 'Cerrar',

      	// Accessibility labels
      	labelMonthNext: 'Siguiente mes',
      	labelMonthPrev: 'Mes anterior',
      	labelMonthSelect: 'Seleciona un mes',
      	labelYearSelect: 'Seleeciona un año',

        format: 'yyyy-mm-dd',
        formatSubmit: 'yyyy-mm-dd',
        hiddenName: true,
        
        // Close on a user action
		onSet: function( arg ){
		        if ( 'select' in arg ){
		            this.close();
		        }
		    }
      });
      $('input, textarea').characterCounter();
      table = llenarTabla.load();

      $('#passOneUsuario').blur(function(e) { 
            checarPassOne();
      });
      $('#passTwoUsuario').blur(function(e) { 
         	checarPassTwo();
      });
      $('#passOneUsuarioActualizar').blur(function(e) { 
            checarPassOneAct();
      });
      $('#passTwoUsuarioActualizar').blur(function(e) { 
            checarPassTwoAct();
      });

});

function checarPassOne(){
	var pass1 = $('#passOneUsuario').val();

	if (pass1.length > 6 && pass1.length < 16) {
			if (pass1.match(/[A-z]/)) {
				if (pass1.match(/[A-Z]/)) {
					if (pass1.match(/\d/)) {
						return true;
					}else{
						swal('Error', 'La contraseña debe contener al menos 1 número.', 'error');
						return false;
					}
				}else{
					swal('Error', 'La contraseña debe contener al menos 1 mayúscula.', 'error');
					return false;
				}
			}else{
				swal('Error', 'La contraseña debe contener al menos 1 letra.', 'error');		
				return false;
			}
	}else{
		swal('Error', 'La contraseña debe tener más de 6 carácteres y menos de 15.', 'error');		
		return false;
	}

}

function checarPassTwo(){

	var pass1 = $('#passOneUsuario').val();
	var pass2 = $('#passTwoUsuario').val();

	if (pass1 != pass2) {

		swal('Error', 'Las contraseñas no coinciden ', 'error');
		return false;
	}
}

function checarPassOneAct(){
	var pass1 = $('#passOneUsuarioActualizar').val();

	if (pass1.length > 6 && pass1.length < 16) {
			if (pass1.match(/[A-z]/)) {
				if (pass1.match(/[A-Z]/)) {
					if (pass1.match(/\d/)) {
						return true;
					}else{
						swal('Error', 'La contraseña debe contener al menos 1 número.', 'error');
						return false;
					}
				}else{
					swal('Error', 'La contraseña debe contener al menos 1 mayúscula.', 'error');
					return false;
				}
			}else{
				swal('Error', 'La contraseña debe contener al menos 1 letra.', 'error');		
				return false;
			}
	}else{
		swal('Error', 'La contraseña debe tener más de 6 carácteres y menos de 15.', 'error');		
		return false;
	}

}

function checarPassTwoAct(){

	var pass1 = $('#passOneUsuarioActualizar').val();
	var pass2 = $('#passTwoUsuarioActualizar').val();

	if (pass1 != pass2) {
		swal('Error', 'Las contraseñas no coinciden ', 'error');
		return false;
	}
}


var llenarTabla = {

    load: function (){

    $.ajax({

        url: root + 'api/usuarios/',
        success: function(response){

            table = $('#dataTable').DataTable({

              "scrollY":        '50vh',
              "scrollCollapse": true,
              "lengthMenu": [
                [5, 10, 25, 50, 100, -1], 
                [5, 10, 25, 50, 100, "Todos"]
              ],
              "iDisplayLength": 5,
              "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún registro disponible.",
                    "sInfo":           "Mostrando de _START_ - _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                "aaData": response.data,
                "columns": [
                    { "data": "name" },
                    { "data": "lastname" },
                    { "data": "email" },
                    { "data": "birthdate" },
                    { "mRender": function ( data, type, row ) {
                            $(".tooltipped").tooltip({delay: 50});
                            $('select').material_select();
                            if (row.role_id === 1) {
                            	return '<a class="btn-floating waves-effect waves-light btn red tooltipped disabled" data-position="left" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>'+
                            		   '<a onclick="confirmarActualizar('+row.id+');" class="btn-floating waves-effect waves-light btn blue tooltipped" data-position="right" data-delay="50" data-tooltip="Modificar"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
							}else{
								return '<a onclick="confirmarEliminar('+row.id+');" class="btn-floating waves-effect waves-light btn red tooltipped" data-position="left" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>'+
								       '<a onclick="confirmarActualizar('+row.id+');" class="btn-floating waves-effect waves-light btn blue tooltipped" data-position="right" data-delay="50" data-tooltip="Modificar"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
							}
                        }
                    }
                ]
            });
            
        }
    });

  }
}

function abrirModalAgregar(){

  $('#formRegistroUsuario')[0].reset();
  $('#agregarRegistro').modal('open');

}

function cerrarModal(){

  swal({
    title: '¿Desea cerrar la ventana?',
    text: "Se perderán los datos que se han ingresado hasta el momento",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí',
    cancelButtonText: 'No'
  }).then(function () {

    $('#agregarRegistro').modal('close');
    $('#actualizarRegistro').modal('close');
    $('#formRegistroUsuario')[0].reset();
    $('#formActualizarUsuario')[0].reset();

  });
 
}

function agregarUsuario(){

			var params = {
			  "name": $('#nameUsuario').val(), 
			  "lastname": $('#lastnameUsuario').val(), 
			  "email": $('#emailUsuario').val(), 
			  "password": $('#passOneUsuario').val(),     
			  "role_id": $('#roleUsuario').val(), 
			  "birthdate": $('#datepicker').val()
			};

		    $.ajax({

		      url: root + 'api/usuarios/',
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
		            title: 'Registro agregado',
		            text: response.message,
		            type: 'success',
		            showConfirmButton: false,
		            showCancelButton: true,
		            timer: 1500
		          }).then(
		            function () {},
		            // handling the promise rejection
		            function (dismiss) {
		              if (dismiss === 'timer') {

		                table.destroy();
		                table = llenarTabla.load();
					    $('#formRegistroUsuario')[0].reset();
					    $('#agregarRegistro').modal('close');
		              
		              }
		            }
		          )

		        });
		      },
		       error: function (XMLHttpRequest, textStatus, errorThrown) {
		        console.log('Error params:');
		        console.log(XMLHttpRequest);

		         swal('Algo salío mal.', XMLHttpRequest.responseJSON.message.toString(), 'error');  
		        
		                console.error('Error: '+ textStatus, errorThrown);
		                
		            }
		    });
}

function confirmarEliminar(id){
  
  swal({

    title: '¿Desea eliminar este registro?',
    text: "Esta acción no se podrá revertir!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si',
    cancelButtonText: 'No',
    confirmButtonClass: 'waves-effect waves-light btn blue',
    cancelButtonClass: 'waves-effect waves-light btn red',
    buttonsStyling: false

  }).then(function () {

    $.ajax({

      url: root+'api/usuarios/'+id+'/eliminar/',
      type: 'POST',
      beforeSend: function(){
        swal({
          title: 'Procesando, por favor espere...',        
          html: '<div class="progress"><div class="indeterminate blue"></div></div>'
        });
      },
      success: function(response){

          swal({

            title: 'Eliminado!',
            text: response.message,
            type: 'success',
            showConfirmButton: false,
            showCancelButton: true,            
            timer: 1500

          }).then(
            function () {},
            // handling the promise rejection
            function (dismiss) {

              if (dismiss === 'timer') {
                
                table.destroy();
                table = llenarTabla.load();

                              
              }
            }
          )

      },
    });

  }, function (dismiss) {
    // dismiss can be 'cancel', 'overlay',
    // 'close', and 'timer'
    if (dismiss === 'cancel') {

      swal(
        'Cancelado',
        'No se ha eliminado ningún registro',
        'error'
      )

    }
  });
}

function confirmarActualizar(id){

  $.ajax({

    url: root + 'api/usuarios/'+id+'/',
    type: 'GET',
    dataType: 'JSON',
    success: function(response){
      $.each(response, function(result, element){
        //console.log(response.data);
        
        $('#idUsuarioActualizar').val(response.data.id);

        $('#nameUsuarioActualizar').val(response.data.name);
        $('#lastnameUsuarioActualizar').val(response.data.lastname);

        $('select').material_select('destroy');
        $('select[name="roleUsuarioActualizar"]').find('option[value="'+response.data.role_id+'"]').attr("selected",true);
        $('select').material_select();

        $('#datepickerActualizar').val(response.data.birthdate);
        $('#emailUsuarioActualizar').val(response.data.email);

        $('#actualizarRegistro').modal('open');


      });
    },
     error: function (XMLHttpRequest, textStatus, errorThrown) {
        /*console.log('Error params:');
        console.log(XMLHttpRequest);*/
        $.each(XMLHttpRequest.responseJSON, function(result, element){
          /*console.log("Result Error");
          console.log(result);
          console.log("Element Error");
          console.log(element);*/
          swal('Algo salío mal.', element.message.toString(), 'error');  
        });
              console.error('Error: '+ textStatus, errorThrown);
              
    }
  });
}

function actualizarRegistro(id){

 var idAct = $('#idUsuarioActualizar').val();

 var params = {
   "name": $('#nameUsuarioActualizar').val(), 
   "lastname": $('#lastnameUsuarioActualizar').val(), 
   "role_id": $('#roleUsuarioActualizar').val(), 
   "birthdate": $('#datepickerActualizar').val(), 
   "email": $('#emailUsuarioActualizar').val(),
   "password": $('#passOneUsuarioActualizar').val()
 };
 
 $.ajax({

   url: root + 'api/usuarios/'+idAct+'/actualizar/',
   type: 'post',
   data: params,
   dataType: 'JSON',
   beforeSend: function(){

     swal({
       title: 'Procesando, por favor espere...',        
       html: '<div class="progress"><div class="indeterminate blue"></div></div>'
     });
     
   },
   success: function(response){

        swal({
          title: 'Registro actualizado',
          text: response.message,
          type: 'success',
          showConfirmButton: false,
          showCancelButton: true,
          timer: 1500
        }).then(
          function () {},
          // handling the promise rejection
          function (dismiss) {
            if (dismiss === 'timer') {

              table.destroy();
              $('#actualizarRegistro').modal('close');
			  $('#formActualizarUsuario')[0].reset();
              table = llenarTabla.load();
            
            }
          }
        )
   },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
       
         swal('Algo salío mal.', XMLHttpRequest.responseJSON.message.toString() , 'error');  

       console.error('Error: '+ textStatus, errorThrown);
             
   }
 });
}
