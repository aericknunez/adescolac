

<li><a href="?corte" class="waves-effect arrow-r"><i class="fas fa-user"></i> Corte Diario </a></li>






<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> Historial<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?hcortes" class="waves-effect"><i class="fas fa-cogs"></i> Historial de Cortes</a></li>


<li><a href="?gmensual" class="waves-effect"><i class="fas fa-cogs"></i> Gastos Mensuales</a></li>

<li><a href="?gra_semestre" class="waves-effect"><i class="fas fa-cogs"></i> Grafico Semestral</a></li>


</ul>
</div>
</li>





<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> Movimientos de Efectivo<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?gastos" class="waves-effect"><i class="fas fa-cog"></i> Gastos y Compras</a></li>
<li><a href="?entradas" class="waves-effect"><i class="fas fa-cogs"></i> Entrada de Efectivo</a></li>

</ul>
</div>
</li>






<li><a class="collapsible-header waves-effect arrow-r"><i class="far fa-user"></i> Cuotas y pagos<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?asociaunidades" class="waves-effect"><i class="fas fa-address-book"></i> Ver Contadores</a></li>
<li><a href="?cuotas" class="waves-effect"><i class="fas fa-money-bill-alt"></i> Todas las cuotas</a></li>

<li><a href="?cuotaspendientes" class="waves-effect"><i class="fas fa-money-bill-alt"></i> Cuotas Pendientes</a></li>
<li><a href="?ordenes_corte" class="waves-effect"><i class="fas fa-address-book"></i> Ordenes de Corte</a></li>
</ul>
</div>
</li>








<li><a class="collapsible-header waves-effect arrow-r"><i class="far fa-user"></i> Asociados<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">


<li><a href="?asociadoadd" class="waves-effect"><i class="fas fa-user"></i> Agrega Asociado</a></li>

<li><a href="?asociadover" class="waves-effect"><i class="fas fa-address-book"></i> Ver Asociados</a></li>

</ul>
</div>
</li>














<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> Facturas<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<!-- <li><a  class="waves-effect"><i class="fas fa-cog"></i> Opciones</a></li> -->
<li><a href="system/imprimir/imprimir.php?op=1" class="waves-effect"><i class="fas fa-cogs"></i> Imprimir Facturas</a></li>

</ul>
</div>
</li>









<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> Configuraciones<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?configuraciones" class="waves-effect"><i class="fas fa-cog"></i> Configuraciones</a></li>

<li><a href="?user" class="waves-effect arrow-r"><i class="fas fa-user"></i> Usuarios </a></li>

<?php if($_SESSION["tipo_cuenta"] == 1) { ?>
<li><a href="?root" class="waves-effect"><i class="fas fa-cogs"></i> Configuraciones Root</a></li>
<li><a href="?precios" class="waves-effect"><i class="fas fa-cogs"></i> Configuraciones Precios</a></li>
<?php } ?>
</ul>
</div>
</li>

<?php  } ?>



<!-- 
<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cog"></i> Opciones<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?configuraciones" class="waves-effect"><i class="fas fa-cog"></i> Configuraciones</a></li>
<li><a href="?root" class="waves-effect"><i class="fas fa-cogs"></i> Configuraciones Root</a></li>
<li><a href="?root" class="waves-effect"><i class="fas fa-cogs"></i> Respaldos</a></li>

</ul>
</div>
</li> -->








<li><a href="application/includes/logout.php" class="waves-effect arrow-r"><i class="fas fa-power-off"></i> Salir </a></li>

</ul>
</li>