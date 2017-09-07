<?php
function turnos_content(){
	global $rb_module_url;
	require_once ABSPATH.'rb-script/class/rb-database.class.php';
	$q = $objDataBase -> Consultar("SELECT * FROM metro_puntos WHERE id=" . $_GET['pto_id']);
	$punto = mysql_fetch_array($q);
	?>
	<div class="wrap-content-list">
	<section class="seccion">
		<div class="seccion-body">
			<h2>Punto de Predicación: <?= $punto['nombre']  ?></h2>
			<p>Seleccione el rango de horas para este turno.</p>
			<form method="POST" action="<?= $rb_module_url ?>turnos.save.php">
				<input type="hidden" value="<?= trim($_GET['pto_id']) ?>" name="punto_id" />
				<input type="hidden" value="<?= trim($_GET['horini']) ?>" name="horaini" />
				<label> Hora Inicio: <?= convertirdorhora($_GET['horini'])?></label>
				<label> Hora Fin:
					<select name="horafin">
					<?php
					// create schedule base
					$horini = $_GET['horini'] + .5;
					$horfin = 22;
					$horact = $horini;
					while ($horact <= $horfin) :
						echo "<option value='" . concero($horact) . "'>" . convertirdorhora($horact) . "</option>";
						$horact = $horact + .5;
					endwhile;
					?>
					</select>
				</label>
				<label>
					<input type="submit" class="btn-primary" value="Guardar Turno" />
					<a href="module.php?pag=predi_tur&pto_id=<?php echo trim($_GET['pto_id']) ?>">Cancelar y volver</a>
				</label>
			</form>
		</div>
	</section>
	</div>
<?php
}
add_function('module_content_main','turnos_content');
?>
