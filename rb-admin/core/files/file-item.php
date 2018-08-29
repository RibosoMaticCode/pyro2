<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$id = $_GET['id'];
$result = $objDataBase->Ejecutar("SELECT * FROM photo WHERE id = $id");
$row = $result->fetch_assoc();
?>
<li class="grid-1">
	<label>
		<div class="cover-img" style="background-image:url('<?= G_SERVER ?>/rb-media/gallery/tn/<?= $row['src'] ?>')" title="<?= $row['src'] ?>">
			<?php
			switch( rb_file_type( $row['type'] ) ){ // Mostrar un icono de algunos archivos permitidos en el sistema
				case 'pdf':
				?>
				<img class="other-file" src="<?= G_SERVER ?>/rb-admin/img/pdf.png" alt="Others files" />
				<?php
				break;
				case 'word':
				?>
				<img class="other-file" src="<?= G_SERVER ?>/rb-admin/img/doc.png" alt="Others files" />
				<?php
				break;
				case 'excel':
				?>
				<img class="other-file" src="<?= G_SERVER ?>/rb-admin/img/xls.png" alt="Others files" />
				<?php
				break;
			}
			?>
			<input class="checkbox" id="art-<?= $row['id'] ?>" type="checkbox" value="<?= $row['id'] ?>" name="items" />
			<span class="filename truncate">
				<a class="fancybox" rel="group" href="<?= G_SERVER ?>/rb-media/gallery/<?= utf8_encode($row['src']) ?>"><?= utf8_encode($row['src']) ?></a>
			</span>
			<span class="edit">
				<a title="Editar" href="<?= G_SERVER ?>/rb-admin/index.php?pag=file_edit&amp;opc=edt&amp;id=<?= $row['id'] ?>">
					<i class="fa fa-pencil" aria-hidden="true"></i>
				</a>
			</span>
			<span class="delete">
				<a title="Eliminar" href="#" style="color:red" class="del-item" data-id="<?= $row['id'] ?>">
					<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
				</a>
			</span>
		</div>
	</label>
</li>
