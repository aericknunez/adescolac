$(document).ready(function(){

    function GetLateral(){ // esta funcion esta en desuso, no existe en el routes
        $.ajax({
            type: "POST",
            url: "application/src/routes.php?op=70",
            success: function(data) {
                $('#lateral').html(data);
            }
        });
    }


//setInterval(GetLateral, 3000);


}); // termina query