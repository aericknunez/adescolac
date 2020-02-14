<?php 
$hoy = Fechas::MesResta(date("d-m-Y"),0);
$dia1 = Fechas::MesResta(date("d-m-Y"),1);
$dia2 = Fechas::MesResta(date("d-m-Y"),2);
$dia3 = Fechas::MesResta(date("d-m-Y"),3);
$dia4 = Fechas::MesResta(date("d-m-Y"),4);
$dia5 = Fechas::MesResta(date("d-m-Y"),5);
 
 ?>


<script>

 //bar
var ctxB = document.getElementById("barChart").getContext('2d');
var myBarChart = new Chart(ctxB, {
    type: 'bar',
    data: {
        labels: [
              "<?php echo Fechas::MesEscrito(date("d-") . $dia5); ?>", 
              "<?php echo Fechas::MesEscrito(date("d-") . $dia4); ?>", 
              "<?php echo Fechas::MesEscrito(date("d-") . $dia3); ?>", 
              "<?php echo Fechas::MesEscrito(date("d-") . $dia2); ?>", 
              "<?php echo Fechas::MesEscrito(date("d-") . $dia1); ?>", 
              "<?php echo Fechas::MesEscrito(date("d-") . $hoy); ?>"
        ],
        datasets: [{

            label: 'Total',
            data: [ 
            <?php echo Helpers::Entero($control->CobrosMes($dia5)); ?>, 
            <?php echo Helpers::Entero($control->CobrosMes($dia4)); ?>, 
            <?php echo Helpers::Entero($control->CobrosMes($dia3)); ?>, 
            <?php echo Helpers::Entero($control->CobrosMes($dia2)); ?>, 
            <?php echo Helpers::Entero($control->CobrosMes($dia1)); ?>, 
            <?php echo Helpers::Entero($control->CobrosMes($hoy)); ?>

            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

</script>
