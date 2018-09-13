<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funciones.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
//$action = "voto_gestion";
$objDataBase = new DataBase;
?>
<h2 class="title">Listado shortcodes galerias carrusel</h2>
<div class="help">
  <h4>Instrucciones de uso</h4>
	<p>Copia el shortcode de la galería deseada, y pega en el contenido de una pagina. La galería con diseño carrusel aparecera automaticamente.</p>
	<p>Si deseas añadir/eliminar fotos en una galeria, debe ir a la seccion Galeria y/o Album.</p>
</div>
<?php
$r = $objDataBase->Ejecutar("SELECT * FROM albums ORDER BY id DESC");
$suscriptores = $r->num_rows;
?>
<section class="seccion">
	<table class="tables">
  <tr>
		<th>Nombre de la galeria</th>
		<th>Configuracion</th>
		<th>Previa</th>
    <th>Shortcode</th>
  </tr>
  <?php
  while ($row = $r->fetch_assoc()):
		?>
    <tr id="carrusel<?= $row['id'] ?>">
      <td><?= $row['nombre'] ?></td>
			<td><a href="<?= G_SERVER ?>/rb-admin/?pag=gal&opc=edt&id=<?= $row['id'] ?>">Configurar</a></td>
			<td><a target="_blank" href="<?= G_SERVER ?>/rb-script/modules/rb-carrusel/preview.php?id=<?= $row['id'] ?>">Ver</a></td>
      <td><code>[carrusel id="<?= $row['id'] ?>"]</code></td>
    </tr>
    <?php
  endwhile;
  ?>
</table>
</div>
