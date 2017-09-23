<div class="wrap-content-list">
	<section class="seccion">
		<div class="seccion-body">
			<form>
				<label>
					Filtrar:
					<input type="text" id="search_input" name="termino" placeholder="Término a buscar" />
				</label>
			</form>
		</div>
	</section>
	<section class="seccion" id="list-pubs">
		<?php
		if ( !defined('ABSPATH') )
			define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');
		
		require_once(ABSPATH."global.php");
		require_once(ABSPATH."rb-script/class/rb-database.class.php");
		
		$rb_module_url = G_SERVER."/rb-script/modules/info/";
		?>
		<table class="box-table-a" border="0" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>Apellidos y Nombres</th>
					<th>Edad</th>
					<th title="Tiempo de Servicio">T.S.</th>
					<th>Sexo</th>
					<th>Fec. Nac</th>
					<th>Fec. Bautismo</th>
					<th>Tel. Movil</th>
					<th>Tel. Fijo</th>
					<th>Puesto Respo.</th>
					<th>Puesto Servi.</th>
					<th>Estado</th>
					<th>Datos Adic.</th>
					<th>Tarjeta</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$qc = "SELECT *, DATE_FORMAT(fecha_nacimiento, '%d-%m-%Y') as fec_nac, DATE_FORMAT(fecha_bautismo, '%d-%m-%Y') as fec_bau, 
				TIMESTAMPDIFF(YEAR, fecha_bautismo, CURDATE()) AS dif_anios, TIMESTAMPDIFF(MONTH, fecha_bautismo, CURDATE()) AS dif_mes, 
				TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS dif_nac_anios, TIMESTAMPDIFF(MONTH, fecha_nacimiento, CURDATE()) AS dif_nac_mes FROM usuarios 
				LEFT JOIN informes_publicador ON usuarios.id = informes_publicador.user_id
				ORDER BY $column";
				
				$q = $objDataBase->Consultar($qc);
				while ($row = mysql_fetch_array($q)):
				?>
				<tr>
					<td>
						<?php
						$style_active = ""; 
						if($row['activo']==0) $style_active = ' style="color:red;" '; 
						?>
						<span <?= $style_active ?>>
						<?= $row['apellidos'] ?>, <?= $row['nombres'] ?>
						</span>
					</td>
					<td>
						<?php if($row['fecha_nacimiento'] > 0) : ?>
						<?= $row['dif_nac_anios'] ?>.<?= $row['dif_nac_mes']-($row['dif_nac_anios']*12) ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if($row['fecha_bautismo'] > 0) : ?>
						<?= $row['dif_anios'] ?>.<?= $row['dif_mes']-($row['dif_anios']*12) ?>
						<?php endif; ?>
					</td>
					<td><?php if($row['sexo']=="h"){ echo "Hombre"; }elseif($row['sexo']=="m"){ echo "Mujer"; } ?></td>
					<td><?= $row['fec_nac'] ?></td>
					<td><?= $row['fec_bau'] ?></td>
					<td><?= $row['telefono-movil'] ?></td>
					<td><?= $row['telefono-fijo'] ?></td>
					<td><?= $row['puesto_responsabilidad'] ?></td>
					<td><?= $row['puesto_servicio'] ?></td>
					<td>
						<?php if($row['activo'] == 0): ?>
						<a class="activar" title="Click para Activar" href="<?= $rb_module_url ?>pubs.active.php?pub_id=<?= $row['id'] ?>&estado=1">Inactivo</a>
						<?php else: ?>
						<a class="activar" title="Click para Desactivar" href="<?= $rb_module_url ?>pubs.active.php?pub_id=<?= $row['id'] ?>&estado=0">Activo</a>
						<?php endif; ?>
					</td>
					<td><a class="fancybox fancybox.ajax" href="<?= $rb_module_url ?>pubs.frm.php?id=<?= $row['id'] ?>">Ver/Editar</a></td>
					<td><a class="fancybox fancybox.ajax" href="<?= $rb_module_url ?>pubs.card.php?id=<?= $row['id'] ?>">Ver</a></td>
				</tr>
				<?php
				endwhile;
				?>
			</tbody>
		</table>	
	</section>
</div>