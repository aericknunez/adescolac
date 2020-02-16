$(document).ready(function(){



	
	$('#btn-addasociado').click(function(e){ /// ventas mensual
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=184",
			method: "POST",
			data: $("#form-addasociado").serialize(),
			beforeSend: function () {
				$('#btn-addasociado').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	        },
			success: function(data){
				$('#btn-addasociado').html('<i class="fa fa-save mr-1"></i> Guardar').removeClass('disabled');	      
				$("#form-addasociado").trigger("reset");
				$("#destinoasociado").html(data);	
			}
		})
	});



	$("#form-addasociado").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});



	$("body").on("click","#delasociado",function(){ // borrar categoria
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
		$("#destinoasociado").html(data);
		$('#ConfirmDelete').modal('hide');
	   	 });
	});


////////////////
	$('#btn-editasociado').click(function(e){ /// actualizar proveedor
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=187",
			method: "POST",
			data: $("#form-editasociado").serialize(),
			success: function(data){
				$("#form-editasociado").trigger("reset");
				$("#destinoasociado").html(data);			
			}
		})
	})
    



	$("#form-editasociado").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});



/// llamar modal ver
	$("body").on("click","#xver",function(){ 
		
		$('#ModalVerAsociado').modal('show');
		
		var key = $(this).attr('key');
		var op = $(this).attr('op');
		var dataString = 'op='+op+'&key='+key;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista").html(data); // lo que regresa de la busquea 		
            }
        });

		$('#btn-pro').attr("href",'?modal=editasociado&key='+key);

		$('#btn-unidades').attr("key",key);
		$('#btn-cuotas-fijas').attr("key",key);
		
	});



///////////// llamar modal para eliminar elemento
	$("body").on("click","#xdelete",function(){ 
		
		var op = $(this).attr('op');
		var hash = $(this).attr('hash');
		
		$('#delasociado').attr("op",op).attr("hash",hash);
		$('#ConfirmDelete').modal('show');
	});




/// llamar modal unidades
	$("body").on("click","#btn-unidades",function(){ 
		
		$('#ModalVerAsociado').modal('hide');
		$('#ModalUnidades').modal('show');
		
		var key = $(this).attr('key');
		var op = $(this).attr('op');
		var dataString = 'op='+op+'&key='+key;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista-unidades").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista-unidades").html(data); // lo que regresa de la busquea 		
            }
        });

        $('#asociado').attr("value",key);

	});


	$('#btn-addunidad').click(function(e){ /// ventas mensual
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=196",
			method: "POST",
			data: $("#form-addunidad").serialize(),
			beforeSend: function () {
				$('#btn-addunidad').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	        },
			success: function(data){
				$('#btn-addunidad').html('<i class="fa fa-save mr-1"></i> Guardar').removeClass('disabled');	      
				$("#form-addunidad").trigger("reset");
				$("#vista-unidades").html(data);	
			}
		})
	});



	$("body").on("click","#delunidad",function(){ // borrar unidad
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	var asociado = $(this).attr('asociado');
	    $.post("application/src/routes.php", {op:op, hash:hash, asociado:asociado}, function(data){
		$("#vista-unidades").html(data);
	   	 });
	});



	$("body").on("click","#pagar",function(){ 
		
		$('#ModalPagar').modal('show');
		
		var hash = $(this).attr('hash');
		var op = $(this).attr('op');
		var dataString = 'op='+op+'&hash='+hash;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista").html(data); // lo que regresa de la busquea 		
            }
        });

	});


	$("body").on("click","#cobrar",function(){ 
		var hash = $(this).attr('hash');
		var op = $(this).attr('op');
		var total = $(this).attr('total');
		var dataString = 'op='+op+'&hash='+hash+'&total='+total;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {  
            	$("#idcuota"+hash).html('CANCELADO');          
                $("#destino").html(data); // lo que regresa de la busquea 		
            }
        });

        $('#ModalPagar').modal('hide');
		

	});






/// llamar modal ver
	$("body").on("click","#xcont",function(){ 
		
		$('#ModalVerUnidades').modal('show');
		
		var unidad = $(this).attr('unidad');
		var key = $(this).attr('key');
		var op = $(this).attr('op');
		var dataString = 'op='+op+'&key='+key+'&unidad='+unidad;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista_unidad").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista_unidad").html(data); // lo que regresa de la busquea 		
            }
        });

		$('#asociado').attr("value",key);
		$('#unidad').attr("value",unidad);

	});


	$('#btn-addlectura').click(function(e){ /// ventas mensual
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=200",
			method: "POST",
			data: $("#form-addlectura").serialize(),
			beforeSend: function () {
				$('#btn-addlectura').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	        },
			success: function(data){
				$('#btn-addlectura').html('<i class="fa fa-save mr-1"></i> Guardar').removeClass('disabled');	      
				$("#form-addlectura").trigger("reset");
				$("#resultado").html(data);	

				//$("#idcuota"+hash).html('CANCELADO');
			}
		})
	});






/// llamar modal  de las cuotas fijas
	$("body").on("click","#btn-cuotas-fijas",function(){ 
		
		$('#ModalVerAsociado').modal('hide');
		$('#ModalCuotasFijas').modal('show');
		
		var key = $(this).attr('key');
		var op = $(this).attr('op');
		var dataString = 'op='+op+'&key='+key;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista-unidades").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista-unidades").html(data); // lo que regresa de la busquea 		
            }
        });

   
	});

/// lcambiar numero de coutas asociado fijo
	$("body").on("click","#cambiarnumero",function(){ 
		
		var asociado = $(this).attr('asociado');
		var accion = $(this).attr('accion');
		var op = $(this).attr('op');
		var dataString = 'op='+op+'&asociado='+asociado+'&accion='+accion;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista-unidades").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista-unidades").html(data); // lo que regresa de la busquea 		
            }
        });

	});



//////////////////////////////////////////////////////

/// cambio de precio
	$("body").on("click","#cambioprecio",function(){ 
		
		$('#ModalCambioPrecio').modal('show');
		
		var contador = $(this).attr('contador');
		var op = $(this).attr('op');
		var dataString = 'op='+op+'&contador='+contador;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista_cambio").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#vista_cambio").html(data); // lo que regresa de la busquea 		
            }
        });

		$('#pcontador').attr("value",contador);

	});




	$('#btn-cambioprecio').click(function(e){ /// ventas mensual
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=192",
			method: "POST",
			data: $("#form-cambioprecio").serialize(),
			beforeSend: function () {
				$('#btn-cambioprecio').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	        },
			success: function(data){
				$('#btn-cambioprecio').html('<i class="fa fa-save mr-1"></i> Guardar').removeClass('disabled');	      
				$("#form-cambioprecio").trigger("reset");
				$("#vista_cambio").html(data);	
			}
		})
	});



	$("body").on("click","#quitarprecio",function(){ // borrar unidad
	var op = $(this).attr('op');
	var contador = $(this).attr('contador');
	    $.post("application/src/routes.php", {op:op, contador:contador}, function(data){
		$("#vista_cambio").html(data);
	   	 });
	});




		$('.datepicker').pickadate({
		  weekdaysShort: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		  weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
		  monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
		  'Noviembre', 'Diciembre'],
		  monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct',
		  'Nov', 'Dic'],
		  showMonthsShort: true,
		  formatSubmit: 'dd-mm-yyyy',
		  close: 'Cancel'
		})


/// llamar modal DE IMRPRIMIR
	$("body").on("click","#print",function(){ 
		
		$('#ModalPrint').modal('show');
		
		var hash = $(this).attr('hash');

		$('#asociadoprint').attr("value",hash);
		
	});


    // $('#imprimir').on("click", function () {
    //   $('#destinoasociado').printThis({
    //     loadCSS: ["http://localhost/cozto/assets/css/font-awesome-582.css","http://localhost/cozto/assets/css/bootstrap.min.css", 
    //     "http://localhost/cozto/assets/css/mdb.min.css"],
    //      base: false
    //   });
    // });






}); // termina query