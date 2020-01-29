<?php
$sec="nivel";
if(isset($_GET['opc'])):
	$opc=$_GET['opc'];
	include('niveles.edit.php');
else:
?>
<script src="<?= G_SERVER ?>rb-admin/core/niveles/funcs.js"></script>
<div class="wrap-content-list">
	<section class="seccion">
		<div class="seccion-header">
			<h2>Niveles de acceso</h2>
			<ul class="buttons">
				<li><a class="button btn-primary" href="<?= G_SERVER ?>rb-admin/?pag=nivel&opc=nvo"><i class="fa fa-plus-circle"></i> <span class="button-label">Nuevo</span></a></li>
				<li><a class="button btn-delete" href="#" id="delete"><i class="fa fa-times"></i> <span class="button-label">Eliminar</span></a></li>
			</ul>
		</div>
		<div class="seccion-body">
			<script>
        $(document).ready(function() {
          $('#table').DataTable({
            "language": {
              "url": "resource/datatables/Spanish.json"
            }
          });
        } );
      </script>
      <table id="table" class="tables table-striped">
				<thead>
					<tr>
						<th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
						<th>Nombre</th>
						<th>Nivel key</th>
						<th>Sub-Nivel key</th>
						<th>Detalles</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php include('niveles.list.php') ?>
				</tbody>
			</table>
		</div>
	</section>
</div>
<?php
endif;
?>
