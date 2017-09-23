<?php
require_once(ABSPATH."rb-script/class/rb-database.class.php");
$objDataBase = new DataBase;
$mes = intval(substr($_GET['period'],0 ,2));
$anio = substr($_GET['period'], 3, 4);
?>
<div class="help" style="display: none"></div>
<div class="wrap-content-list">
	<section class="seccion">
		<div class="seccion-header">Consolidado</div>
		<div class="seccion-body">
			<?php
			// GRUPOS
			/*$mes = 9;
			$anio = 2016;*/
			$q_grupos = $objDataBase->Ejecutar("SELECT * FROM usuarios_grupos ORDER BY nombre");

			$cuadros = 4; // 25% cada bloque
			$bloque=1;

			while($r_grupos = $q_grupos->fetch_assoc() ):
			?>
			<?php if($bloque==1){ ?><div class="group_block_main"><?php }?>
			<div class="group_block">
				<h3><?= $r_grupos['nombre'] ?></h3>
				<table>
					<thead>
						<tr>
							<th></th>
							<th>Publicador</th>
							<th>Pub</th>
							<th>Vid</th>
							<th>Hor</th>
							<th>Rev</th>
							<th>Eb</th>
							<th>Obs</th>
						</tr>
					</thead>
					<tbody>
					<?php
					// PUBLICADORES
					/*$q_publi = $objDataBase->Ejecutar("SELECT i.id, u.apellidos, u.nombres, u.grupo_id, i.pub, i.vid, i.hor, i.rev, i.est, i.obs, i.mes, i.anio
					FROM usuarios u LEFT JOIN informes i ON u.id = i.usuario_id
					WHERE u.grupo_id = ".$r_grupos['id']." AND (i.mes = $mes OR i.mes IS NULL) AND (i.anio = $anio OR i.anio IS NULL)
					ORDER BY u.apellidos");*/
					$q_publi = "SELECT i.id AS info_id, u.id, u.apellidos, u.nombres, u.grupo_id, i.pub, i.vid, i.hor, i.rev, i.est, i.obs, i.mes, i.anio, i.servi, u.activo, u.tipo
						FROM usuarios u LEFT JOIN informes i ON u.id = i.usuario_id AND i.mes= $mes OR i.mes IS NULL AND i.anio = $anio OR i.anio IS NULL
						WHERE u.activo = 1 AND u.tipo = 0 AND u.grupo_id = ".$r_grupos['id']." ORDER BY u.apellidos"; // CONSULTA ACTUALIZADA 03-01-17

					$result_publi = $objDataBase->Ejecutar($q_publi);
					$i = 1;
					while($r_publica = $result_publi->fetch_assoc() ):
					?>
						<tr>
							<?php if($r_publica['mes'] === NULL): ?>
								<td class="tcenter"><?= $i ?></td>
							<?php else: ?>
								<td class="tcenter"><a href="<?= G_SERVER ?>/rb-admin/module.php?pag=info&opc=edt&id=<?= $r_publica['info_id'] ?>"><?= $i ?></a></td>
							<?php endif; ?>
							<td><?= $r_publica['apellidos'] ?>, <?= $r_publica['nombres'] ?></td>
							<td class="tcenter"><?= $r_publica['pub'] ?></td>
							<td class="tcenter"><?= $r_publica['vid'] ?></td>
							<td class="tcenter"><?= $r_publica['hor'] ?></td>
							<td class="tcenter"><?= $r_publica['rev'] ?></td>
							<td class="tcenter"><?= $r_publica['est'] ?></td>
							<td class="tcenter">
								<?php
								/*switch($r_publica['servi']){
									case 'pub': break;
									case 'pa' :
										echo "PA";
										break;
									case 'pr':
										echo "PR";
										break;
								}*/
								?>
								<?= $r_publica['servi'] ?>
							</td>
						</tr>
					<?php
					$i++;
					endwhile;
					?>
					</tbody>
					<?php
					// SUMATORIA POR GRUPO
					$q_sum = $objDataBase->Ejecutar("SELECT u.grupo_id, SUM(i.pub) AS sum_pub, SUM(i.vid) AS sum_vid, SUM(i.hor) AS sum_hor, SUM(i.rev) AS sum_rev, SUM(i.est) AS sum_est, i.obs, i.mes, i.anio
					FROM usuarios u LEFT JOIN informes i ON u.id = i.usuario_id
					WHERE u.grupo_id = ".$r_grupos['id']." AND (i.mes = $mes OR i.mes IS NULL) AND (i.anio = $anio OR i.anio IS NULL)
					ORDER BY u.apellidos");
					$r_sum = $q_sum->fetch_assoc();
					?>
					<tfoot>
						<tr>
							<th></th>
							<th>Totales</th>
							<th><?= $r_sum['sum_pub']?></th>
							<th><?= $r_sum['sum_vid']?></th>
							<th><?= $r_sum['sum_hor']?></th>
							<th><?= $r_sum['sum_rev']?></th>
							<th><?= $r_sum['sum_est']?></th>
							<th></th>
						</tr>
					</tfoot>
				</table>
			</div> <!-- fin group_block -->
			<?php $bloque++; if($bloque>$cuadros){ ?></div><?php $bloque=1; }?>
			<?php
			endwhile;
			?>
			<div class="group_block">
				<h3>Totales</h3>
				<table>
					<thead>
						<tr>
							<th></th>
							<th>Cant.</th>
							<th>Pub</th>
							<th>Vid</th>
							<th>Hor</th>
							<th>Rev</th>
							<th>Eb</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// SUMATORIA TODOS PUBLICADORES
						$q_pub_cant = "SELECT * FROM  informes
						WHERE mes = $mes AND anio = $anio AND (pub > 0 OR vid > 0 OR hor > 0 OR rev > 0 OR est > 0)
						AND servi='pub'";
						$q = $objDataBase->Ejecutar($q_pub_cant);
						$pub_cant = $q->num_rows;

						$q_sumtot = $objDataBase->Ejecutar("SELECT u.grupo_id, SUM(i.pub) AS sum_pub, SUM(i.vid) AS sum_vid, SUM(i.hor) AS sum_hor, SUM(i.rev) AS sum_rev, SUM(i.est) AS sum_est, i.obs, i.mes, i.anio, i.servi
						FROM usuarios u LEFT JOIN informes i ON u.id = i.usuario_id
						WHERE (i.mes = $mes OR i.mes IS NULL) AND (i.anio = $anio OR i.anio IS NULL)
						AND servi='pub'");
						$r_sumtot = $q_sumtot->fetch_assoc();
						?>
						<tr>
							<td>Publicadores</td>
							<td class="center"><?= $pub_cant ?></td>
							<td class="center"><?= $r_sumtot['sum_pub']?></td>
							<td class="center"><?= $r_sumtot['sum_vid']?></td>
							<td class="center"><?= $r_sumtot['sum_hor']?></td>
							<td class="center"><?= $r_sumtot['sum_rev']?></td>
							<td class="center"><?= $r_sumtot['sum_est']?></td>
						</tr>
						<?php
						// SUMATORIA TODOS PREC AUX
						$q_pa_cant = "SELECT * FROM  informes
						WHERE mes = $mes AND anio = $anio AND (pub > 0 OR vid > 0 OR hor > 0 OR rev > 0 OR est > 0)
						AND servi='pa'";
						$q = $objDataBase->Ejecutar($q_pa_cant);
						$pa_cant = $q->num_rows;

						$q_sumtot = $objDataBase->Ejecutar("SELECT u.grupo_id, SUM(i.pub) AS sum_pub, SUM(i.vid) AS sum_vid, SUM(i.hor) AS sum_hor, SUM(i.rev) AS sum_rev, SUM(i.est) AS sum_est, i.obs, i.mes, i.anio, i.servi
						FROM usuarios u LEFT JOIN informes i ON u.id = i.usuario_id
						WHERE (i.mes = $mes OR i.mes IS NULL) AND (i.anio = $anio OR i.anio IS NULL)
						AND servi='pa'");
						$r_sumtot = $q_sumtot->fetch_assoc();
						?>
						<tr>
							<td>Prec. Aux.</td>
							<td class="center"><?= $pa_cant ?></td>
							<td class="center"><?= $r_sumtot['sum_pub']?></td>
							<td class="center"><?= $r_sumtot['sum_vid']?></td>
							<td class="center"><?= $r_sumtot['sum_hor']?></td>
							<td class="center"><?= $r_sumtot['sum_rev']?></td>
							<td class="center"><?= $r_sumtot['sum_est']?></td>
						</tr>
						<?php
						// SUMATORIA TODOS PREC REG
						$q_pr_cant = "SELECT * FROM  informes
						WHERE mes = $mes AND anio = $anio AND (pub > 0 OR vid > 0 OR hor > 0 OR rev > 0 OR est > 0)
						AND servi='pr'";
						$q = $objDataBase->Ejecutar($q_pr_cant);
						$pr_cant = $q->num_rows;

						$q_sumtot = $objDataBase->Ejecutar("SELECT u.grupo_id, SUM(i.pub) AS sum_pub, SUM(i.vid) AS sum_vid, SUM(i.hor) AS sum_hor, SUM(i.rev) AS sum_rev, SUM(i.est) AS sum_est, i.obs, i.mes, i.anio, i.servi
						FROM usuarios u LEFT JOIN informes i ON u.id = i.usuario_id
						WHERE (i.mes = $mes OR i.mes IS NULL) AND (i.anio = $anio OR i.anio IS NULL)
						AND servi='pr'");
						$r_sumtot = $q_sumtot->fetch_assoc();
						?>
						<tr>
							<td>Prec. Reg.</td>
							<td class="center"><?= $pr_cant ?></td>
							<td class="center"><?= $r_sumtot['sum_pub']?></td>
							<td class="center"><?= $r_sumtot['sum_vid']?></td>
							<td class="center"><?= $r_sumtot['sum_hor']?></td>
							<td class="center"><?= $r_sumtot['sum_rev']?></td>
							<td class="center"><?= $r_sumtot['sum_est']?></td>
						</tr>
						<?php
						// SUMATORIA TODOS GRUPOS
						$q_sumtot = $objDataBase->Ejecutar("SELECT u.grupo_id, SUM(i.pub) AS sum_pub, SUM(i.vid) AS sum_vid, SUM(i.hor) AS sum_hor, SUM(i.rev) AS sum_rev, SUM(i.est) AS sum_est, i.obs, i.mes, i.anio, i.servi
						FROM usuarios u LEFT JOIN informes i ON u.id = i.usuario_id
						WHERE (i.mes = $mes OR i.mes IS NULL) AND (i.anio = $anio OR i.anio IS NULL) ");
						$r_sumtot = $q_sumtot->fetch_assoc();
						?>
						<tr>
							<td>Publicadores</td>
							<td class="center"></td>
							<td class="center"><?= $r_sumtot['sum_pub']?></td>
							<td class="center"><?= $r_sumtot['sum_vid']?></td>
							<td class="center"><?= $r_sumtot['sum_hor']?></td>
							<td class="center"><?= $r_sumtot['sum_rev']?></td>
							<td class="center"><?= $r_sumtot['sum_est']?></td>
						</tr>
						<?php
						// CANTIDAD QUIENES NO INFORMARON
						$q_noinf_cant = "SELECT * FROM  informes
						WHERE mes = $mes AND anio = $anio AND pub = 0 AND vid = 0 AND hor = 0 AND rev = 0 AND est = 0";
						$q = $objDataBase->Ejecutar($q_noinf_cant);
						$noinf_cant = $q->num_rows;
						?>
						<tr>
							<td colspan="6">
								No informaron
							</td>
							<td class="center">
								<?= $noinf_cant ?>
							</td>
						</tr>
						<?php
						// Consulta: numero de publicadores activos
						$q_cant_pubs = $objDataBase->Ejecutar("SELECT * FROM usuarios WHERE activo=1 AND tipo=0");

						$num_pubs = $q_cant_pubs->num_rows;
						?>
						<tr>
							<td colspan="6">
								Cantidad publicadores
							</td>
							<td class="center">
								<?= $num_pubs ?>
							</td>
						</tr>
						<?php
						// CANTIDAD QUIENES NO TIENE ESTUDIOS BIBLICOS
						$q_noest_cant = "SELECT * FROM  informes
						WHERE mes = $mes AND anio = $anio AND est = 0";
						$q = $objDataBase->Ejecutar($q_noest_cant);
						$noest_cant = $q->num_rows;
						?>
						<tr>
							<td colspan="6">
								No tienen est. bíblicos
							</td>
							<td class="center">
								<?= $noest_cant ?>
							</td>
						</tr>
					</body>
				</table>
			</div>
		</div>
		<div style="padding:20px 0">
		<p>Si todos los informes fueron ingresados, puede <a href="<?= G_SERVER ?>/rb-script/modules/info/infofinal.generate.php?m=<?= $mes ?>&y=<?= $anio ?>">generar reporte final</a>.</p>
		</div>
	</section>
</div>
