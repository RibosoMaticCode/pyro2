<?php
function horarios_content(){
	global $rb_module_url;
	require_once ABSPATH.'rb-script/class/rb-database.class.php';
	$q = $objDataBase->Consultar("SELECT * FROM metro_puntos WHERE id=".$_GET['pto_id']);
	$punto = mysql_fetch_array($q);
	?>
	<div class="wrap-content-list">
	<section class="seccion">
		<div class="seccion-body">
		<h2>Punto de Predicación: <?= $punto['nombre']  ?></h2>
		<p>Seleccione al publicador que estará en ese horario</p>
		<form method="POST" action="<?= $rb_module_url ?>horarios.save.php">

			<input type="hidden" value="<?php echo trim($_GET['pto_id']) ?>" name="punto_id" />
			<input type="hidden" value="<?php echo trim($_GET['day']) ?>" name="dia" />
			<input type="hidden" value="<?php echo trim($_GET['horini']) ?>" name="horaini" />
			<input type="hidden" value="<?php echo trim($_GET['horfin']) ?>" name="horafin" />
			<label for="">
				D&iacute;a:
				<?php echo rb_numadia($_GET['day']) ?>
			</label>
			<label>
				Hora Inicio:
				<?php echo convertirdorhora($_GET['horini']) ?>
			</label>
			<label>
				Hora Fin:
				<?php echo convertirdorhora($_GET['horfin']) ?>
			</label>
			<label>
				Publicador:
				<select name="usuario_id">
					<?php
					$q = $objDataBase->Consultar("SELECT id, nombres, apellidos FROM usuarios WHERE tipo=1 OR tipo=3 OR tipo=4 ORDER BY nombres ASC");
					while ($r = mysql_fetch_array($q)):
						echo "<option value=".$r['id'].">".$r['nombres']." ".$r['apellidos']."</option>";
					endwhile;
					?>
				</select>
			</label>
			<label>
				<input class="btn-primary" type="submit" value="Guardar Horario" />
				<a href="module.php?pag=predi_hor&id=<?php echo trim($_GET['pto_id']) ?>">Cancelar y volver</a>
			</label>
		</form>
		</div>
	</section>
	</div>
	<?php
}
add_function('module_content_main','horarios_content');
?>
