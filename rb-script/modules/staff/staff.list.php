<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funciones.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
$objDataBase = new DataBase;
?>
<div id="toolbar">
  <a class="btn-primary" href="<?= G_SERVER ?>/rb-admin/module.php?pag=staff&id=0">Nuevo</a>
</div>
<section class="seccion">
	<table class="tables">
  <tr>
    <th>Foto</th>
    <th>Nombres</th>
    <th>Cargo</th>
    <th>Area</th>
    <th>Ciudad</th>
		<th>Correo</th>
		<th>Telefono</th>
    <th></th>
  </tr>
  <?php
  $r = $objDataBase->Ejecutar("SELECT * FROM staff");
  while ($row = $r->fetch_assoc()) {
    ?>
    <tr id="depre_<?= $row['id'] ?>">
      <td><?= $row['photo_id'] ?></td>
      <td><?= $row['name'] ?></td>
      <td><?= $row['position'] ?></td>
      <td><?= $row['area'] ?></td>
      <td><?= $row['city'] ?></td>
			<td><?= $row['email'] ?></td>
			<td><?= $row['telefono'] ?></td>
      <td>
        <a href="<?= G_SERVER ?>/rb-admin/module.php?pag=staff&id=<?= $row['id']?>">Editar</a>
        <a class="delete" data-id="<?= $row['id'] ?>" href="#">Eliminar</a>
      </td>
    </tr>
    <?php
  }
  ?>
</table>
</div>
