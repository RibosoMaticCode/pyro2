<script>
$(document).ready(function() {
	$('.del-info').click(function( event ){
		event.preventDefault();
		var id = $(this).attr('data-id');

		var eliminar = confirm("[?] Confirmar la eliminación permanente de este dato. ¿Continuar?");
		if ( eliminar ) {
			$.ajax({
				url: '<?= $rb_module_url ?>info.delete.php?id='+id,
				cache: false,
				type: "GET",
				success: function(data){
					if(data.resultado=="ok"){
						notify('Eliminado');
			    		$( "#result-block" ).show().delay(5000);
						$( "#result-block" ).html(data.contenido);
						setTimeout(function(){
							window.location.href = '<?= $urlreload ?>';
						}, 1000);
					}
				}
			});
		}
	});
});
</script>
<div id="sidebar-left">
	<ul class="buttons-edition">
		<li><a class="btn-primary" href="<?= G_SERVER ?>/rb-admin/module.php?pag=info&amp;opc=nvo"><img src="img/add-white-16.png" alt="Nuevo"> Nuevo</a></li>
		<li><a class="btn-primary" href="#" id="edit"><img src="img/edit-white-16.png" alt="Editar"> Editar</a></li>
		<li><a class="btn-primary" href="#" id="delete"><img src="img/del-white-16.png" alt="delete"> Eliminar</a></li>
	</ul>
</div>
<?php // Desconcadena
$mes = intval(substr($_GET['period'],0 ,2));
$anio = substr($_GET['period'], 3, 4);
?>
<div class="wrap-content-list">
	<section class="seccion">
		<table class="tables" border="0" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
					<th>Nro.</th>
					<th>Mes</th>
					<th>Año</th>
					<th>Publicador</th>
					<th>Pub.</th>
					<th>Vid.</th>
					<th>Horas</th>
					<th>Rev.</th>
					<th>Est. Bib.</th>
					<th>Obs.</th>
				</tr>
			</thead>
			<tbody>
			<?php
			require_once(ABSPATH."rb-script/class/rb-database.class.php");
			$objDataBase = new DataBase;
			$regMostrar = $_COOKIE['user_show_items'];
			$colOrder = "id"; // column name table
			$Ord = "DESC"; // A-Z

			if(isset($_GET['page']) && ($_GET['page']>0)){
				$RegistrosAEmpezar=($_GET['page']-1)*$regMostrar;
			}else{
				$RegistrosAEmpezar=0;
			}

			$q = $objDataBase->Ejecutar("SELECT * FROM informes WHERE mes=$mes AND anio=$anio ORDER BY $colOrder $Ord"); //LIMIT $RegistrosAEmpezar, $regMostrar");
			$i=1;
			while ($row = $q->fetch_assoc()):
				$Usuario = rb_get_user_info($row['usuario_id']);
			?>
				<tr>
				<td><?= $i ?></td>
					<td><input id="info-<?= $row['id']?>" type="checkbox" value="<?= $row['id']?>" name="items" /></td>
					<td><?= rb_mes_nombre($row['mes']) ?></td>
					<td><?= $row['anio'] ?></td>
					<td><?= $Usuario['nombres'] ?>
						<div class="options">
							<span><a title="Editar" href="?pag=info&amp;opc=edt&amp;id=<?= $row['id']?>">Editar</a></span>
							<span><a data-id="<?= $row['id'] ?>" class="del-info del-color" title="Eliminar" href="#">Eliminar</a></span></td>
						</div>
					</td>
					<td><?= $row['pub'] ?></td>
					<td><?= $row['vid'] ?></td>
					<td><?= $row['hor'] ?></td>
					<td><?= $row['rev'] ?></td>
					<td><?= $row['est'] ?></td>
					<td><?= $row['obs'] ?></td>
				</tr>
			<?php
			$i++;
			endwhile;
			?>
			</tbody>
		</table>
	</section>
</div>
