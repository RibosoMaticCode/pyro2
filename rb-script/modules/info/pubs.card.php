<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funciones.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$rb_module_url = G_SERVER."/rb-script/modules/info/";

$urlreload=G_SERVER.'/rb-admin/module.php?pag=info_pub';

// Data user
$qu = $objDataBase->Consultar("SELECT id, apellidos, nombres FROM usuarios WHERE id=".$_GET['id']); 
$row_user = mysql_fetch_array($qu);
?>

<section class="seccion">
	<div class="seccion-body">
		<div id="result" style="text-align: center;"></div>
		<h2 style="text-align: center"><?= $row_user['apellidos'] ?>, <?= $row_user['nombres'] ?></h2>
		
		<table class="box-table-a" style="border:1px solid #F1F1F1">
			<thead>
				<tr>
					<th>Mes</th>
					<th>Pub.</th>
					<th>Vid.</th>
					<th>Horas</th>
					<th>Rev.</th>
					<th>Est.</th>
					<th>Ser.</th>
					<th>Observaciones</th>
				</tr>
			</thead>
			<?php
			$qi = $objDataBase->Consultar("SELECT * FROM informes WHERE usuario_id=".$_GET['id']." ORDER BY anio, mes ASC LIMIT 12"); 
			?>
			<tbody>
				<?php
				while($row = mysql_fetch_array($qi)):
				?>
				<tr>
					<td><?= substr(rb_mes_nombre($row['mes']),0,3) ?> - <?= $row['anio'] ?></td>
					<td><?= $row['pub'] ?></td>
					<td><?= $row['vid'] ?></td>
					<td><?= $row['hor'] ?></td>
					<td><?= $row['rev'] ?></td>
					<td><?= $row['est'] ?></td>
					<td><?= $row['servi'] ?></td>
					<td><?= $row['obs'] ?></td>
				</tr>
				<?php
				endwhile;
				?>
			</tbody>
			<?php
			$qi = $objDataBase->Consultar("SELECT AVG(pub) AS prom_pub, AVG(vid) AS prom_vid, AVG(hor) AS prom_hor, AVG(rev) AS prom_rev, AVG(est) AS prom_est FROM informes WHERE usuario_id=".$_GET['id']." LIMIT 12"); 
			$row = mysql_fetch_array($qi)
			?>
			<tfoot>
				<tr>
					<th></th>
					<th><?= round($row['prom_pub'],2) ?></th>
					<th><?= round($row['prom_vid'],2) ?></th>
					<th><?= round($row['prom_hor'],2) ?></th>
					<th><?= round($row['prom_rev'],2) ?></th>
					<th><?= round($row['prom_est'],2) ?></th>
					<th></th>
					<th></th>
				</tr>
			</tfoot>
		</table>
	</div>
</section>