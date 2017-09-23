<?php
require_once(ABSPATH."rb-script/class/rb-database.class.php");
$mes = intval(substr($_GET['period'],0 ,2));
$anio = substr($_GET['period'], 3, 4);
?>
<div class="help" style="display: none"></div>
<div class="wrap-content-list">
	<section class="seccion">
		<div class="seccion-header"><h3>Informe Final - No editable</h3></div>
		<div class="seccion-body">
			<?php
			// GRUPOS
			$q_grupos = $objDataBase->Consultar("SELECT grupo FROM informes_final GROUP BY grupo ORDER BY grupo");

			$cuadros = 4; // 25% cada bloque
			$bloque=1;

			while($r_grupos = mysql_fetch_array($q_grupos)):
			?>
			<?php if($bloque==1){ ?><div class="group_block_main"><?php }?>
			<div class="group_block">
				<h3><?= $r_grupos['grupo'] ?></h3>
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
					// INFORMES
					$q_publi = $objDataBase->Consultar("SELECT id, usuario_id, apellidos, nombres, grupo, pub, vid, hor, rev, est, obs, mes, anio
						FROM informes_final WHERE grupo='".$r_grupos['grupo']."' AND mes=$mes AND anio=$anio ORDER BY apellidos");

					$i = 1;
					while($r_publica = mysql_fetch_array($q_publi)):
					?>
						<tr>
							<td class="tcenter"><?= $i ?></td>
							<td><a class="fancybox fancybox.ajax" href="<?= G_SERVER ?>/rb-script/modules/info/pubs.card.php?id=<?= $r_publica['usuario_id'] ?>"><?= $r_publica['apellidos'] ?>, <?= $r_publica['nombres'] ?></a></td>
							<td class="tcenter"><?= $r_publica['pub'] ?></td>
							<td class="tcenter"><?= $r_publica['vid'] ?></td>
							<td class="tcenter"><?= $r_publica['hor'] ?></td>
							<td class="tcenter"><?= $r_publica['rev'] ?></td>
							<td class="tcenter"><?= $r_publica['est'] ?></td>
							<td class="tcenter"></td>
						</tr>
					<?php
					$i++;
					endwhile;
					?>
					</tbody>
					<?php
					// SUMATORIA POR GRUPO
					$q_sum = $objDataBase->Consultar("SELECT grupo, SUM(pub) AS sum_pub, SUM(vid) AS sum_vid, SUM(hor) AS sum_hor, SUM(rev) AS sum_rev, SUM(est) AS sum_est, obs, mes, anio
						FROM informes_final WHERE grupo='".$r_grupos['grupo']."' AND mes=$mes AND anio=$anio");

					$r_sum = mysql_fetch_array($q_sum);
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

			// SUMATORIA TODOS GRUPOS
			$q_sumtot = $objDataBase->Consultar("SELECT grupo, SUM(pub) AS sum_pub, SUM(vid) AS sum_vid, SUM(hor) AS sum_hor, SUM(rev) AS sum_rev, SUM(est) AS sum_est, obs, mes, anio
						FROM informes_final WHERE mes=$mes AND anio=$anio");

			$r_sumtot = mysql_fetch_array($q_sumtot);
			?>
			<!--<div class="group_block">
				<h3>Totales</h3>
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
						<tr>
							<td></td>
							<td></td>
							<td><?= $r_sumtot['sum_pub']?></td>
							<td><?= $r_sumtot['sum_vid']?></td>
							<td><?= $r_sumtot['sum_hor']?></td>
							<td><?= $r_sumtot['sum_rev']?></td>
							<td><?= $r_sumtot['sum_est']?></td>
							<td></td>
						</tr>
					</body>
				</table>
			</div>-->
			<!-- REPORTE FINAL -->
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
						$q_pub_cant = "SELECT * FROM  informes_final
						WHERE mes = $mes AND anio = $anio AND (pub > 0 OR vid > 0 OR hor > 0 OR rev > 0 OR est > 0)
						AND servi='pub'";

						$pub_cant = mysql_num_rows($objDataBase->Consultar($q_pub_cant));

						$q_sumtot = $objDataBase->Consultar("SELECT SUM(pub) AS sum_pub, SUM(vid) AS sum_vid, SUM(hor) AS sum_hor, SUM(rev) AS sum_rev, SUM(est) AS sum_est FROM informes_final WHERE mes = $mes AND anio = $anio AND servi='pub'");
						$r_sumtot = mysql_fetch_array($q_sumtot);
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
						$q_pa_cant = "SELECT * FROM  informes_final
						WHERE mes = $mes AND anio = $anio AND (pub > 0 OR vid > 0 OR hor > 0 OR rev > 0 OR est > 0)
						AND servi='pa'";

						$pa_cant = mysql_num_rows($objDataBase->Consultar($q_pa_cant));

						$q_sumtot = $objDataBase->Consultar("SELECT SUM(pub) AS sum_pub, SUM(vid) AS sum_vid, SUM(hor) AS sum_hor, SUM(rev) AS sum_rev, SUM(est) AS sum_est FROM informes_final WHERE mes = $mes AND anio = $anio AND servi='pa'");
						$r_sumtot = mysql_fetch_array($q_sumtot);
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
						$q_pr_cant = "SELECT * FROM  informes_final
						WHERE mes = $mes AND anio = $anio AND (pub > 0 OR vid > 0 OR hor > 0 OR rev > 0 OR est > 0)
						AND servi='pr'";

						$pr_cant = mysql_num_rows($objDataBase->Consultar($q_pr_cant));

						$q_sumtot = $objDataBase->Consultar("SELECT SUM(pub) AS sum_pub, SUM(vid) AS sum_vid, SUM(hor) AS sum_hor, SUM(rev) AS sum_rev, SUM(est) AS sum_est FROM informes_final WHERE mes = $mes AND anio = $anio AND servi='pr'");
						$r_sumtot = mysql_fetch_array($q_sumtot);
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
						$q_all_cant = "SELECT * FROM  informes_final
						WHERE mes = $mes AND anio = $anio AND (pub > 0 OR vid > 0 OR hor > 0 OR rev > 0 OR est > 0)";

						$all_cant = mysql_num_rows($objDataBase->Consultar($q_all_cant));

						$q_sumtot = $objDataBase->Consultar("SELECT SUM(pub) AS sum_pub, SUM(vid) AS sum_vid, SUM(hor) AS sum_hor, SUM(rev) AS sum_rev, SUM(est) AS sum_est FROM informes_final WHERE mes = $mes AND anio = $anio");
						$r_sumtot = mysql_fetch_array($q_sumtot);
						?>
						<tr>
							<td>Publicadores</td>
							<td class="center"><strong><?= $all_cant ?></strong></td>
							<td class="center"><strong><?= $r_sumtot['sum_pub']?></strong></td>
							<td class="center"><strong><?= $r_sumtot['sum_vid']?></strong></td>
							<td class="center"><strong><?= $r_sumtot['sum_hor']?></strong></td>
							<td class="center"><strong><?= $r_sumtot['sum_rev']?></strong></td>
							<td class="center"><strong><?= $r_sumtot['sum_est']?></strong></td>
						</tr>
						<?php
						// CANTIDAD QUIENES NO INFORMARON
						$q_noinf_cant = "SELECT * FROM  informes_final
						WHERE mes = $mes AND anio = $anio AND pub = 0 AND vid = 0 AND hor = 0 AND rev = 0 AND est = 0";

						$noinf_cant = mysql_num_rows($objDataBase->Consultar($q_noinf_cant));
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
						$q_cant_pubs = $objDataBase->Consultar("SELECT * FROM usuarios WHERE activo=1 AND tipo=0");

						$num_pubs = mysql_num_rows($q_cant_pubs);
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
						$q_noest_cant = "SELECT * FROM  informes_final
						WHERE mes = $mes AND anio = $anio AND est = 0";

						$noest_cant = mysql_num_rows($objDataBase->Consultar($q_noest_cant));
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
	</section>
</div>
