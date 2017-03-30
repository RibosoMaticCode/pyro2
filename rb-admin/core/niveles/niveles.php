<h2 class="title">Niveles de acceso</h2>
<div class="page-bar">Inicio > Usuario</div>

<?php
$sec="nivel";
if(isset($_GET['opc'])):
	$opc=$_GET['opc'];
	include('niveles.edit.php');
else:
?>
<div id="sidebar-left">
	<ul class="buttons-edition">
		<li><a class="btn-primary" href="../rb-admin/?pag=nivel&amp;opc=nvo"><img src="img/add-white-16.png" alt="Nuevo"> Nuevo</a></li>
		<li><a class="btn-primary" href="#" id="edit"><img src="img/edit-white-16.png" alt="Editar"> Editar</a></li>
		<li><a class="btn-primary" href="#" id="delete"><img src="img/del-white-16.png" alt="delete"> Eliminar</a></li>
	</ul>
</div>
<div class="wrap-content-list">
	<section class="seccion">
		<table class="tables" border="0" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
					<th>Nombre</th>
					<th>Nivel key</th>
					<th>Detalles</th>
				</tr>
			</thead>
			<tbody>
				<?php include('niveles.list.php') ?>
			</tbody>
		</table>
	</section>
</div>
<?php
endif;
?>
