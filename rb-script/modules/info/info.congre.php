<?php
require_once(ABSPATH."rb-script/class/rb-database.class.php");
?>
<script>
$(document).ready(function() {
	$('.link-show-details').click(function(event){
		console.log($(this).attr("data-listid"));
		var list = $(this).attr("data-listid");
		
		$('#'+list).slideToggle();		
	});
});
</script>
<div class="wrap-content-list-centered">
	<section class="seccion">
		<div class="seccion-header">
			<h3>Datos Actuales de la Congregación</h3>
		</div>
		<div class="seccion-body">
			<ul>
				<li>
					<?php
					$q = $objDataBase->Consultar("SELECT *, DATE_FORMAT(fecha_nacimiento, '%d-%m-%Y') as fec_nac, DATE_FORMAT(fecha_bautismo, '%d-%m-%Y') as fec_bau, 
					TIMESTAMPDIFF(YEAR, fecha_bautismo, CURDATE()) AS dif_anios, TIMESTAMPDIFF(MONTH, fecha_bautismo, CURDATE()) AS dif_mes, 
					TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS dif_nac_anios, TIMESTAMPDIFF(MONTH, fecha_nacimiento, CURDATE()) AS dif_nac_mes 
					FROM usuarios LEFT JOIN informes_publicador ON usuarios.id = informes_publicador.user_id WHERE puesto_servicio='pr' ORDER BY apellidos");
						
					$cant_pr = mysql_num_rows($q);
					?>
					<div class="cols-container">
						<div class="cols-10-md">
							<a class="link-show-details" data-listid="list-pr" href="#">Precursores Regulares</a>
						</div>
						<div class="cols-2-md center"><strong><?= $cant_pr ?></strong></div>
					</div>
					
					<div class="list-hide" id="list-pr">
						<table class="table-info">
							<thead>
								<tr>
									<th>Nombres</th>
									<th>Actividad</th>
								</tr>
							</thead>
							<tbody>
								<?php
								while($row_pr = mysql_fetch_array($q)):
								?>
								<tr>
									<td><?= $row_pr['apellidos'] ?> <?= $row_pr['nombres'] ?></td>
									<td class="center"><a class="fancybox fancybox.ajax" href="<?= $rb_module_url ?>pubs.card.php?id=<?= $row_pr['id'] ?>">Ver</a></td>
								</tr>
								<?php
								endwhile;
								?>
							</tbody>
						</table>
					</div>
				</li>
				<li>
					<?php
					$q = $objDataBase->Consultar("SELECT *, DATE_FORMAT(fecha_nacimiento, '%d-%m-%Y') as fec_nac, DATE_FORMAT(fecha_bautismo, '%d-%m-%Y') as fec_bau, 
					TIMESTAMPDIFF(YEAR, fecha_bautismo, CURDATE()) AS dif_anios, TIMESTAMPDIFF(MONTH, fecha_bautismo, CURDATE()) AS dif_mes, 
					TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS dif_nac_anios, TIMESTAMPDIFF(MONTH, fecha_nacimiento, CURDATE()) AS dif_nac_mes 
					FROM usuarios LEFT JOIN informes_publicador ON usuarios.id = informes_publicador.user_id WHERE puesto_servicio='pa' ORDER BY apellidos");
						
					$cant_pr = mysql_num_rows($q);
					?>
					<div class="cols-container">
						<div class="cols-10-md">
							<a href="#">Precursores Auxiliares (indefinidos)</a>
						</div>
						<div class="cols-2-md center"><strong><?= $cant_pr ?></strong></div>
					</div>
					
					<div class="list-hide">
						<table class="table-info">
							<thead>
								<tr>
									<th>Nombres</th>
									<th>Actividad</th>
								</tr>
							</thead>
							<tbody>
								<?php
								while($row_pr = mysql_fetch_array($q)):
								?>
								<tr>
									<td><?= $row_pr['apellidos'] ?> <?= $row_pr['nombres'] ?></td>
									<td class="center"><a class="fancybox fancybox.ajax" href="<?= $rb_module_url ?>pubs.card.php?id=<?= $row_pr['id'] ?>">Ver</a></td>
								</tr>
								<?php
								endwhile;
								?>
							</tbody>
						</table>
					</div>
				</li>
				<li>
					<a href="#">Publicadores no bautizados</a>
				</li>
				<li>
					<a href="#">Publicadores activos</a>
				</li>
				<li>
					<a href="#">Publicadores inactivos</a>
				</li>
				<li>
					<a href="#">Publicadores disciplinados</a>
				</li>
				<li>
					<a href="#">Expulsados</a>
				</li>
			</ul>
		</div>
	</section>
</div>