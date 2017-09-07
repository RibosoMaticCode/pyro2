<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH."rb-script/class/rb-database.class.php";
$objDataBase = new DataBase;

$r = $objDataBase->Consultar("SELECT * FROM metro_publicacion");
while ($row = mysql_fetch_array($r)):
?>
	<tr>
		<td>
		<?php $Img = rb_get_photo_details_from_id($row['image_id']) ?>
		<img style="max-width:65px" src="<?= $Img['file_url'] ?>" alt="img" />
		</td>
		<td><?= $row['titulo'] ?>
			<div class="options">
				<span><a title="Editar" class="fancybox fancybox.ajax" href="<?= $rb_module_url ?>publi.frm.php?id=<?= $row['id'] ?>">Editar</a></span>
				<span><a title="Eliminar" class="del-item" data-id="<?= $row['id'] ?>" style="color:red" href="#">Eliminar</a></span></td>
			</div>
		</td>
		<td><?= $row['codigo'] ?></td>
	</tr>
<?php
endwhile;
?>
