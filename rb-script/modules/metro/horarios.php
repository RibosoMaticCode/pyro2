<?php
$pto_id = trim($_GET['id']);

function horarios_content(){
	global $rb_module_url;
	global $pto_id;
	require_once ABSPATH.'rb-script/class/rb-database.class.php';
	$urlreload = G_SERVER."/rb-admin/module.php?pag=predi_hor&id=".$pto_id;

	$q = $objDataBase->Consultar("SELECT * FROM metro_puntos WHERE id=$pto_id");
	$punto = mysql_fetch_array($q);
	?>
	<script>
	$(document).ready(function() {
		// Clic en Eliminar
		$('.del-pub').click(function( event ){
			event.preventDefault();
			var id = $(this).attr('data-id');
			var dia = $(this).attr('data-dia');
			var horini = $(this).attr('data-horini');
			var usuid = $(this).attr('data-usuid');

			var eliminar = confirm("[?] Confirmar la eliminación permanente de este dato. ¿Continuar?");
			if ( eliminar ) {
				$.ajax({
					url: '<?= $rb_module_url ?>horarios.del.php?pto_id='+id+'&dia='+dia+'&horini='+horini+'&usu_id='+usuid+'&ajax',
					cache: false,
					type: "GET",
					success: function(data){
						if(data.resultado=="ok"){
				    		$('#frmHorarios').hide();
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
	<div class="help">
		<h4>Información</h4>
		<p>Esta seccion le permite asignar a los distintos voluntarios a un turno especifico, asi crear su horario de predicacion.</p>
	</div>
	<div class="wrap-content-list">
		<div id="result-block" style="text-align: center">

		</div>
	<section class="seccion">
		<div class="seccion-body">
			<h2>
			Punto de predicación: <span style="color:#000"><?= trim($punto['nombre']) ?></span>
			</h2>
			<p><a href="module.php?pag=predi_ptos">Cancelar y volver</a></p>
	<?php
	$r = $objDataBase->Consultar("SELECT * FROM metro_turnos WHERE punto_id=$pto_id");
	$numero_filas = mysql_num_rows($r);

	if($numero_filas==0) {
		?>
		<p>[!] No cuenta con turnos este horario, haga clic en ¿Desea agregar turno? arriba</p>
		<?php
	}else{
	?>
		<table width="100%" cellpadding="0" cellspacing="0" class="tables">
			<thead>
				<tr>
					<th><h3>Horarios</h3></th>
					<th><h3>Lunes</h3></th>
					<th><h3>Martes</h3></th>
					<th><h3>Miercoles</h3></th>
					<th><h3>Jueves</h3></th>
					<th><h3>Viernes</h3></th>
					<th><h3>Sabado</h3></th>
					<th><h3>Domingo</h3></th>
				</tr>
			</thead>
			<tbody>
			<?php
			$qr = $objDataBase -> Consultar("SELECT * FROM metro_turnos WHERE punto_id=" . $pto_id . " ORDER BY turno_inicio ASC");
			while ($r = mysql_fetch_array($qr)) :
				?>
				<tr>
				<td><strong><span style="text-align:center"><?= convertirdorhora($r['turno_inicio'])?> - <?= convertirdorhora($r['turno_fin'])?></span></strong></td>
				<?php
				/* dias */
				$i=1;
				while($i<=7){
					$dia=$i;
					?>
					<td class="box">
					<?php
					$rs = $objDataBase -> Consultar("SELECT h.*, u.nombres, u.apellidos FROM metro_horarios h, usuarios u WHERE h.usuario_id = u.id AND h.punto_id=" . $pto_id . " AND h.dia=" . $dia . " AND h.horainicio='".$r['turno_inicio']."'");
					$numero_filas = mysql_num_rows($rs);
					if($numero_filas>0){
						while($ro = mysql_fetch_array($rs)){
							?>
							<div class='wrap-file'>
							<span class="name-pub"><?= dividirnombre($ro['nombres'])?> <?= dividirnombre($ro['apellidos']) ?></span>
							<a data-id="<?= $pto_id ?>" data-dia="<?= $dia ?>" data-horini="<?= $r['turno_inicio'] ?>" data-usuid="<?= $ro['usuario_id']?>" class="del-pub" href="<?= $rb_module_url ?>horarios.del.php?pto_id=<?= $pto_id ?>&dia=<?= $dia ?>&horini=<?= $r['turno_inicio'] ?>&usu_id=<?= $ro['usuario_id']?>">
								<img src="<?= $rb_module_url ?>img/delete.png" alt="Eliminar" />
							</a> <br />
							</div>
							<?php
						}
					}
					if($numero_filas<2){
						?>
						<div>
						<!--<a class="add-pub" href="module.php?pag=predi_hor&opc=new&horini=<?= $r['turno_inicio']?>&horfin=<?=$r['turno_fin']?>&day=<?= $dia ?>&pto_id=<?= $pto_id ?>"><span style="color:green;">Asignar Publicador</span></a>-->
						<a class="add-pub fancybox fancybox.ajax" href="<?= $rb_module_url ?>horarios.form.ajax.php?pag=predi_hor&opc=new&horini=<?= $r['turno_inicio']?>&horfin=<?=$r['turno_fin']?>&day=<?= $dia ?>&pto_id=<?= $pto_id ?>"><span style="color:green;">Asignar Publicador</span></a>
						</div>
						<?php
					}
					?>
					</td>
					<?php
					$i++;
				}
				?>
				</td>
				<?php
			endwhile;
			?>
			</tbody>
		</table>
		Ultima modificacion:
		<?php
		$rs = $objDataBase->Consultar("SELECT DATE_FORMAT(fecha_mod, '%d') AS dia, DATE_FORMAT(fecha_mod, '%m') AS mes, DATE_FORMAT(fecha_mod, '%Y') AS anio, TIME_FORMAT(fecha_mod, '%h:%i:%s %p') as hora FROM metro_horarios WHERE punto_id=$pto_id order by fecha_mod desc limit 1");
		$row = mysql_fetch_array($rs);
		?>
		<?= $row['dia'] ?> de <?= rb_mes_nombre($row['mes']) ?> del <?= $row['anio'] ?>, a las <?= $row['hora'] ?>
		<?php
	}
	?>
		</div>
	</section>
	</div>
	<?php
}
add_function('module_content_main','horarios_content');
?>
