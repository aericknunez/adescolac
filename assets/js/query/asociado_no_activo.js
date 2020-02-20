$(document).ready(function(){




	$("body").on("click","#CobrarNoActivo",function(){ 
		var asociado = $(this).attr('asociado');
		var op = $(this).attr('op');
		var cantidad = $(this).attr('cantidad');
		var cuota = $(this).attr('cuota');
		var dataString = 'op='+op+'&asociado='+asociado+'&cuota='+cuota+'&cantidad='+cantidad;

		$.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#vista-unidades").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {          
                $("#vista-unidades").html(data);		
            }
        });

        $('#ModalCuotasFijas').modal('hide');
		

	});







}); // termina query