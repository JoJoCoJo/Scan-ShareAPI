
    var root = 'http://scan-share.api/';
    var table;
    var editor;
    var callAjax;
    
$(document).ready(function(){

      $(".button-collapse").sideNav();
      $('.tooltipped').tooltip({delay: 50});
      table = llenarTabla.reload();
      
});

var llenarTabla = {
    reload: function (){

    $.ajax({
        url: root + 'api/targets/',
        type: 'GET',
        dataType: 'JSON',
        success: function(response){

            table = $('#dataTable').DataTable({
              
              "scrollY":        '50vh',
              "scrollX": true,
              "scrollCollapse": true,
              "aLengthMenu": [
                  [5, 10, 25, 50, 100, "-1"],
                  [5, 10, 25, 50, 100, "Todos"]
              ],
              "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún registro disponible.",
                    "sInfo":           "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros",
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
                            return '<a onclick="confirmarEliminar('+row.id+');" class="btn-floating waves-effect waves-light btn red tooltipped" data-position="left" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>'+
                                   '<a onclick="confirmarActualizar('+row.id+');" class="btn-floating waves-effect waves-light btn blue tooltipped" data-position="right" data-delay="50" data-tooltip="Modificar"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                        }
                    }
                ]
            });
            $('select').material_select();
            $('.tooltipped').tooltip({delay: 50});
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
      success: function(response){

        $.each(response, function(result, element){

          console.log(response);

          swal({

            title: 'Eliminado!',
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
                table = llenarTabla.reload();

                              
              }
            }
          )

        });
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