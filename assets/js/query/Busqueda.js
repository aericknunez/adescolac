$(document).ready(function(){

function Mostrar(){
	$("#formu").show();
}

function Esconder(){
	$("#formu").hide();
}

Esconder();

// busqueda actualizar
	$("#key").keyup(function(){ /// para la caja de busqueda
		$.ajax({
		type: "POST",
		url: "application/src/routes.php?op=50",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#muestra-busqueda").css("background","#FFF url(assets/img/LoaderIcon.gif) no-repeat 550px");
		},
		success: function(data){
			$("#muestra-busqueda").show();
			$("#muestra-busqueda").html(data);
			$("#key").css("background","#FFF");
		}
		});
	});



    $('#btn-busqueda').click(function(e){ /// para que funcione la busqueda al dar enter
    e.preventDefault();
    $.ajax({
            url: "application/src/routes.php?op=51",
            method: "POST",
            data: $("#p-busqueda").serialize(),
            success: function(data){ 
                $("#muestra-busqueda").hide();
                $("#contenido").html(data); // lo que regresa de la busquea 
                $("#p-busqueda").trigger("reset");
                Mostrar();
            }
        })
    });




//////// cancel 
	$("body").on("click","#cancel-p",function(){
		$("#muestra-busqueda").hide();
		$("#p-busqueda").trigger("reset"); 
	});




	$("body").on("click","#select-p",function(){ 
		var unidad = $(this).attr('unidad');
		var op = $(this).attr('op');
		var key = $(this).attr('key');
		var dataString = 'op='+op+'&unidad='+unidad+'&key='+key;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#contenido").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) { 
            	$("#muestra-busqueda").hide(); 
    			$("#contenido").html(data); // lo que regresa de la busquea 
		    	$("#p-busqueda").trigger("reset");
		    	 Mostrar();	
            }
        });

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
				$("#contenido").html(data);	

				Esconder();
			}
		})
	});






}); // termina query