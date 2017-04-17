
    var root = 'http://scan-share.api/';
    var table;
    var map, measureTool, marker;
    
$(document).ready(function(){

      $(".button-collapse").sideNav();
      $('.modal').modal({
        dismissible: false
      });
      $('input, textarea').characterCounter();
      table = llenarTabla.load();

});

function abrirModalAgregar(){

  $('#formRegistroObjetivo')[0].reset();
  $('#agregarRegistro').modal('open');
  initMap(20.96712966892257, -89.62250175350647, 1);

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
    $('#formRegistroObjetivo')[0].reset();
    $('#formActualizarObjetivo')[0].reset();

  });
 
}

var llenarTabla = {

    load: function (){

    $.ajax({

        url: root + 'api/targets/',
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
                "aaData": response[0].data,
                "columns": [
                    { "data": "name" },
                    { "data": "description" },
                    { "data": "phone" },
                    { "mRender": function ( data, type, row ) {
                            $(".tooltipped").tooltip({delay: 50});
                            $('select').material_select();
                            return '<a onclick="confirmarEliminar('+row.id+');" class="btn-floating waves-effect waves-light btn red tooltipped" data-position="left" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>'+
                                   '<a onclick="confirmarActualizar('+row.id+');" class="btn-floating waves-effect waves-light btn blue tooltipped" data-position="right" data-delay="50" data-tooltip="Modificar"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+
                                   '<a onclick="generarQR(\''+row.qr_id+'\', \''+row.name+'\');" class="btn-floating waves-effect waves-light btn black tooltipped" data-position="left" data-delay="50" data-tooltip="Generar QR"><i class="fa fa-qrcode" aria-hidden="true"></i></a>';
                        }
                    }
                ]
            });
            
        }
    });

  }
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

      url: root+'api/targets/'+id+'/eliminar/',
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

    url: root + 'api/targets/'+id+'/',
    type: 'GET',
    dataType: 'JSON',
    success: function(response){
      $.each(response, function(result, element){
        //console.log(response.data);
        
        $('#idActualizarObjetivo').val(response.data.id);

        $('#nameActualizarObjetivo').val(response.data.name);
        $('#descriptionActualizarObjetivo').val(response.data.description);

        $('select').material_select('destroy');
        $('select[name="typeActualizarObjetivo"]').find('option[value="'+response.data.type+'"]').attr("selected",true);
        $('select').material_select();
        
        $('#phoneActualizarObjetivo').val(response.data.phone);
        $('#facebookActualizarObjetivo').val(response.data.facebook);
        $('#twitterActualizarObjetivo').val(response.data.twitter);
        $('#instagramActualizarObjetivo').val(response.data.instagram); 
        $('#youtubeActualizarObjetivo').val(response.data.youtube); 
        $('#urlActualizarObjetivo').val(response.data.url);

        $('#latitudeActualizarObjetivo').val(response.data.latitude);
        $('#longitudeActualizarObjetivo').val(response.data.longitude);

        initMap(parseFloat(response.data.latitude), parseFloat(response.data.longitude), 2);

        $('#minmtsActualizarObjetivo').val(response.data.min_mts);

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

 var idAct = $('#idActualizarObjetivo').val();

 var params = {
   "name": $('#nameActualizarObjetivo').val(), 
   "description": $('#descriptionActualizarObjetivo').val(), 
   "type": $('#typeActualizarObjetivo').val(), 
   "phone": $('#phoneActualizarObjetivo').val(), 
   "facebook": $('#facebookActualizarObjetivo').val(), 
   "twitter": $('#twitterActualizarObjetivo').val(), 
   "instagram": $('#instagramActualizarObjetivo').val(), 
   "youtube": $('#youtubeActualizarObjetivo').val(), 
   "url": $('#urlActualizarObjetivo').val(), 
   "latitude": $('#latitudeActualizarObjetivo').val(), 
   "longitude": $('#longitudeActualizarObjetivo').val(), 
   "min_mts": $('#minmtsActualizarObjetivo').val()
 };

 $.ajax({

   url: root + 'api/targets/'+idAct+'/actualizar/',
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
              $('#formActualizarObjetivo')[0].reset();
              table = llenarTabla.load();
            
            }
          }
        )
   },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
       
       console.log('Error params:');
       console.log(XMLHttpRequest);
       
       $.each(XMLHttpRequest.responseJSON, function(result, element){
       
         console.log("Result Error");
         console.log(result);
         console.log("Element Error");
         console.log(element);

         swal('Algo salío mal.', element.message.toString() , 'error');  

       });

       console.error('Error: '+ textStatus, errorThrown);
             
   }
 });
}

function agregarObjetivo(){

  var params = {
    "name": $('#nameObjetivo').val(), 
    "description": $('#descriptionObjetivo').val(), 
    "type": $('#typeObjetivo').val(), 
    "phone": $('#phoneObjetivo').val(), 
    "facebook": $('#facebookObjetivo').val(), 
    "twitter": $('#twitterObjetivo').val(), 
    "instagram": $('#instagramObjetivo').val(), 
    "youtube": $('#youtubeObjetivo').val(), 
    "url": $('#urlObjetivo').val(), 
    "latitude": $('#latitudeObjetivo').val(), 
    "longitude": $('#longitudeObjetivo').val(), 
    "min_mts": $('#minmtsObjetivo').val()
  };

      $.ajax({

        url: root + 'api/targets/',
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

                  table.destroy();
                  table = llenarTabla.load();
                  $('#formRegistroObjetivo')[0].reset();
                  $('#agregarRegistro').modal('close');
                
                }
              }
            )

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

function generarQR(qr, name){
  
  swal({
    title: 'Código QR',
    html: '<div id="qr"></div> Ahora puede decargar su Código QR del objetivo:<br/>"'+name+'"'
  });
  update_qrcode(qr);

}


function initMap(latitude, longitude, id) {

  if (id == 1) {

    var ubicacion = {lat: latitude, lng: longitude};

    map = new google.maps.Map(document.getElementById('map'), {

      center: ubicacion,
      zoom: 18,
      streetViewControl: false,
      mapTypeControlOptions: {
            mapTypeIds: ['ROADMAP']
          }
    });

    marker = new google.maps.Marker({

      map: map,
      draggable: true,
      animation: google.maps.Animation.DROP,
      position: ubicacion

    });

    measureTool = new MeasureTool(map, {

      showSegmentLength: true,
      tooltip: false,
      unit: MeasureTool.UnitTypeId.METRIC // metric or imperial

    });

    marker.addListener('dragend',function(event){

      $('#latitudeObjetivo').val(event.latLng.lat());
      $('#longitudeObjetivo').val(event.latLng.lng());

    });

  }else if(id == 2){

    var ubicacion = {lat: latitude, lng: longitude};

    map = new google.maps.Map(document.getElementById('mapAct'), {

      center: ubicacion,
      zoom: 18,
      streetViewControl: false,
      mapTypeControlOptions: {
            mapTypeIds: ['ROADMAP']
          }
    });

    marker = new google.maps.Marker({

      map: map,
      draggable: true,
      animation: google.maps.Animation.DROP,
      position: ubicacion

    });

    measureTool = new MeasureTool(map, {

      showSegmentLength: true,
      tooltip: false,
      unit: MeasureTool.UnitTypeId.METRIC // metric or imperial

    });

    marker.addListener('dragend',function(event){

      $('#latitudeActualizarObjetivo').val(event.latLng.lat());
      $('#longitudeActualizarObjetivo').val(event.latLng.lng());

    });
  }
}