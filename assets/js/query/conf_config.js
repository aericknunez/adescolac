$(document).ready(function()
{


		$('.datepicker').pickadate({
		  weekdaysShort: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		  weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
		  monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
		  'Noviembre', 'Diciembre'],
		  monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct',
		  'Nov', 'Dic'],
		  showMonthsShort: true,
		  formatSubmit: 'dd',
		  close: 'Cancel'
		})





	$('#btn-config').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=10",
			method: "POST",
			data: $("#form-config").serialize(),
			success: function(data){
				$("#ventana").html(data);
				window.location.href="?configuraciones";
			}
		})
	})
$("#form-config").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});


$('#btn-root').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=11",
			method: "POST",
			data: $("#form-root").serialize(),
			success: function(data){
				$("#ventana").html(data);
				window.location.href="?root";
			}
		})
	})
$("#form-root").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});



$('#btn-precios').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=13",
			method: "POST",
			data: $("#form-precios").serialize(),
			success: function(data){
				$("#contenido").html(data);
			}
		})
	})
$("#form-precios").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});



	// $("body").on("click","#tablemod",function(){ // modificar tablas
	// var op = $(this).attr('op');
	// var tabla = $(this).attr('tabla');
	// var accion = $(this).attr('accion');
	// var edo = $(this).attr('edo');
	//     $.post("application/src/routes.php", {op:op, tabla:tabla, accion:accion, edo:edo}, function(data){
	// 	$("#contenido").html(data);
	//    	 });
	// });




});
