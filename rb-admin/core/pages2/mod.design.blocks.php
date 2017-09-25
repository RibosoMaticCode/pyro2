<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';

$type = $_GET['t'];
$temp_id = $_GET['temp_id'];

switch($type):
	case 'slide':
		require_once ABSPATH.'rb-script/class/rb-galerias.class.php';
		$q = $objDataBase->Ejecutar("SELECT * FROM albums");
		?>
		<li class="item" id="<?= $temp_id ?>" data-type="<?= $type ?>">
			<div class="box-header">
				<h4>Slide</h4>
				<a class="toggle" href="#">
					<span class="arrow-up">&#9650;</span>
					<span class="arrow-down">&#9660;</span>
				</a>
				<a class="boxdelete" href="#">X</a>
			</div>
			<div class="box-body">
				<label>
					<span>Seleccionar galería</span>
					<select class="slide_name" name="slides">
						<?php
						while($r = $q->fetch_assoc()):
						?>
						<option value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
						<?php
						endwhile;
						?>
					</select>
				</label>
			</div>
		</li>
	<?php
	break;
	case 'gallery':
		require_once ABSPATH.'rb-script/class/rb-galerias.class.php';
		$q = $objDataBase->Ejecutar("SELECT * FROM albums");
		?>
		<li class="item" id="<?= $temp_id ?>" data-type="<?= $type ?>">
			<div class="box-header">
				<h4>Galería</h4>
				<a class="toggle" href="#">
					<span class="arrow-up">&#9650;</span>
					<span class="arrow-down">&#9660;</span>
				</a>
				<a class="boxdelete" href="#">X</a>
			</div>
			<div class="box-body">
				<label>
					<span>Seleccionar galería</span>
					<select class="gallery_name" name="slides">
						<?php
						while($r = $q->fetch_assoc()):
						?>
						<option value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
						<?php
						endwhile;
						?>
					</select>
				</label>
				<label>
					<span>Elementos a mostrar</span>
					<input type="text" required value="3" max="50" min="1" class="gallery_show" />
				</label>
				<label>
					<span>Mostrar por fila</span>
					<select class="gallery_byrow">
						<?php
						$i=1;
						while($i<=12):
						?>
						<option value="<?= $i ?>" <?php if($i==3) echo 'selected="selected"' ?>><?= $i ?></option>
						<?php
						$i++;
						endwhile;
						?>
					</select>
				</label>
			</div>
		</li>
	<?php
	break;
	case 'html':
		?>
		<script>
		$(document).ready(function() {
		    $( ".cols-html" ).sortable({
		    	placeholder: "placeholder"
			});
		});
		</script>
		<li class="item" id="<?= $temp_id ?>" data-type="<?= $type ?>">
			<div class="box-header">
				<h4>HTML</h4>
				<a class="toggle" href="#">
					<span class="arrow-up">&#9650;</span>
					<span class="arrow-down">&#9660;</span>
				</a>
				<a class="boxdelete" href="#">X</a>
			</div>
			<div class="box-body">
				<a class="add-column" href="#">(+) Agregar Columna</a>
				<ul class="cols-html">
					<li class="col">
						<span class="col-head">
							<a class="close-column" href="#">X</a>
						</span>
						<textarea class="col-content"></textarea>
					</li>
				</ul>
			</div>
		</li>
	<?php
	break;
	case 'posts':
		require_once ABSPATH.'rb-script/class/rb-categorias.class.php';
		$q = $objDataBase->Ejecutar("SELECT * FROM categorias");
		?>
		<li class="item" id="<?= $temp_id ?>" data-type="<?= $type ?>">
			<div class="box-header">
				<h4>Publicaciones</h4>
				<a class="toggle" href="#">
					<span class="arrow-up">&#9650;</span>
					<span class="arrow-down">&#9660;</span>
				</a>
				<a class="boxdelete" href="#">X</a>
			</div>
			<div class="box-body">
				<label>
					<span>Seleccionar categoria</span>
					<select class="category_name">
						<option value="all">Todas</option>
						<?php
						while($r = $q->fetch_assoc()):
						?>
						<option value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
						<?php
						endwhile;
						?>
					</select>
				</label>
				<label>
					<span>Elementos a mostrar</span>
					<input type="text" required value="3" max="50" min="1" class="category_show" />
				</label>
				<span>Presentación</span>
				<label><input type="radio" name="presenta" value="lista" class="category_list" checked /> Listado</label>
				<label><input type="radio" name="presenta" value="grid" class="category_grid" /> Cuadricula</label>
				<label>
					<span>Mostrar por fila</span>
					<select class="category_byrow">
						<?php
						$i=1;
						while($i<=12):
						?>
						<option value="<?= $i ?>" <?php if($i==4) echo 'selected="selected"' ?>><?= $i ?></option>
						<?php
						$i++;
						endwhile;
						?>
					</select>
				</label>
			</div>
		</li>
	<?php
	break;
endswitch;
?>
