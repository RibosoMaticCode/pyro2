<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH."rb-script/class/rb-database.class.php";
$objDataBase = new DataBase;

$r = $objDataBase->Consultar("SELECT * FROM metro_almacen");
while ($row = mysql_fetch_array($r)):
?>
	<tr>
		<td><?= $row['nombre_almacen'] ?>
			<div class="options">
				<span><a title="Editar" class="fancybox fancybox.ajax" href="<?= $rb_module_url ?>almacen.frm.php?id=<?= $row['id'] ?>">Editar</a></span>
				<span><a title="Eliminar" class="del-item" data-id="<?= $row['id'] ?>" style="color:red" href="#">Eliminar</a></span></td>
			</div>
		</td>
		<td><?= $row['coordenadas'] ?></td>
		<td>
		<?php $Img = rb_get_photo_details_from_id($row['foto_id']) ?>
		<img style="max-width:80px" src="<?= $Img['thumb_url'] ?>" alt="img" />
		</td>
	</tr>
<?php
endwhile;
?>
