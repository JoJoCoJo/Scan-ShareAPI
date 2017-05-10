
function cerrar() {

	swal({
	  title: '¿Desea cerrar sesión?',
	  text: "Esta a punto de salir del administrador",
	  type: 'warning',
	  showCancelButton: true,
	  cancelButtonText: 'No',
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si'
	}).then(function () {
		window.location.href = "/cerrar";
	});
}