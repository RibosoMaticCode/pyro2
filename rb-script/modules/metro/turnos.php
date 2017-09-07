<?php
function turnos_content(){
	global $rb_module_url;
	require_once ABSPATH.'rb-script/class/rb-database.class.php';

	$pto_id = trim($_GET['pto_id']);
	$q = $objDataBase -> Consultar("SELECT * FROM metro_puntos WHERE id=$pto_id");
	$punto = mysql_fetch_array($q);
	?>
	<div class="help">
		<h4>Información</h4>
		<p>En está sección se pueden agrupar horas para formar turnos. El turno se asigna para todos los días. Cada Punto de Predicación cuenta con sus respectivos turnos.</p>
	</div>
	<div class="wrap-content-list">

	<section class="seccion">
		<div class="seccion-body">
			<h2>
			Punto de predicación: <span style="color:#000"><?= trim($punto['nombre']) ?></span>
			</h2>
			<p><a href="module.php?pag=predi_ptos">Cancelar y volver</a></p>

	<table width="40%" class="tables" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<th><h3>Horas a seleccionar</h3></th>
		</tr>
		<?php
		$array_main = array();
		$qr = $objDataBase -> Consultar("SELECT * FROM metro_turnos WHERE punto_id=" . $pto_id . " ORDER BY turno_inicio ASC");
		while ($r = mysql_fetch_array($qr)) :
			$detalle = array("turini" => $r['turno_inicio'], "turfin" => $r['turno_fin']);
			$array_main[] = $detalle;
		endwhile;
		// create schedule base
		$horini = 7;
		$horfin = 21.5;
		$horact = $horini;

		sort($array_main);
		$nums_array = count($array_main);

		while ($horact <= $horfin) :
			?>
			<tr>
			<?php
			$noshowlink=1;
			$horactini = $horact;
			$i = 0;
			while ($i < $nums_array) :
				if ($array_main[$i]['turini'] == $horact) :
					$horact = $array_main[$i]['turfin']-.5;
					$noshowlink = 0;
					break;
				endif;
				$i++;
			endwhile;
			?>
			<td>
			<?php
			$horactfin = $horact + .5;
			echo convertirdorhora($horactini) . ' - ' . convertirdorhora($horactfin);
			if($noshowlink==1):?>
				 [<a style="color:green;" href="../rb-admin/module.php?pag=predi_tur&opc=new&horini=<?= concero($horactini) ?>&pto_id=<?= $pto_id ?>"> seleccionar </a>]
			<?php
			else:
			?>
				<span><a title="Eliminar" href="<?= $rb_module_url ?>turnos.del.php?pto_id=<?= $pto_id ?>&horini=<?= concero($horactini) ?>"><img src="<?= $rb_module_url ?>img/delete.png" alt="Eliminar" /></a></span>
			<?php
			endif;
			?>
			</td>
			</tr>
			<?php
			$horact = $horact + .5;
		endwhile;
		?>
	</table>
		</div>
	</section>
	</div>
<?php
}
add_function('module_content_main','turnos_content');
?>
