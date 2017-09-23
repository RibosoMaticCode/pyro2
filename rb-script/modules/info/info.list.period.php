<?php
require_once(ABSPATH."rb-script/class/rb-database.class.php");
require_once(ABSPATH."rb-script/modules/info/funciones.php");
$objDataBase = new DataBase;
$q = $objDataBase->Ejecutar("SELECT mes, anio FROM informes GROUP by anio, mes ORDER BY mes, anio");
while ($row = $q->fetch_assoc()):
	?>
	<tr>
		<td><input id="info-<?= $row['mes']?>" type="checkbox" value="<?= $row['mes']?>" name="items" /></td>
		<td><?= rb_mes_nombre($row['mes']) ?></td>
		<td class="center"><?= $row['anio'] ?></td>
		<?php
		// Consulta: numero de publicadores activos
		$q_cant_pubs = $objDataBase->Ejecutar("SELECT * FROM usuarios WHERE activo=1 AND tipo=0");
		$num_pubs = $q_cant_pubs->num_rows;

		// Consulta: informes registrados
		$q_cant_infos = $objDataBase->Ejecutar("SELECT * FROM informes WHERE mes=".$row['mes']." AND anio=".$row['anio']);
		$num_infos = $q_cant_infos->num_rows;
		?>
		<td class="center">
			<a href="<?= G_SERVER ?>/rb-admin/module.php?pag=info&opc=details&period=<?= concero($row['mes'])?>-<?= $row['anio']?>">Listado</a>
		</td>
		<td class="center">
			<?php
			$qif = $objDataBase->Ejecutar("SELECT mes, anio FROM informes_final WHERE mes=".$row['mes']." AND anio=".$row['anio']);
			$rif = $qif->num_rows;
			if($rif>0):
			?>
			<a href="<?= G_SERVER ?>/rb-admin/module.php?pag=info&opc=final&period=<?= concero($row['mes'])?>-<?= $row['anio']?>">Reporte Final Enviado</a>
			<?php
			else:
			?>
			<a href="<?= G_SERVER ?>/rb-admin/module.php?pag=info&opc=summary&period=<?= concero($row['mes'])?>-<?= $row['anio']?>">Borrador (<?= $num_infos ?>/<?= $num_pubs ?>)</a>
			<?php
			endif;
			?>
		</td>
	</tr>
<?php
endwhile;
?>
