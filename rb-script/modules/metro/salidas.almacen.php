<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once ABSPATH.'rb-script/funciones.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
$almacen_id = $_GET['almacen_id'];
?>
<table class="tables">
  <thead>
    <tr>
      <th>Portada</th>
      <th>Publicaciones</th>
      <?php
      $i=1;
      while($i<=12):
      ?>
      <th style="text-align:center"><?= rb_mes_nombre($i)?><br /><?= DATE('Y') ?></th>
      <?php $i++; endwhile ?>
    </tr>
  </thead>
  <tbody>
    <?php
    $qp = $objDataBase->Consultar("SELECT * FROM metro_publicacion");
    ?>
    <?php while($r = mysql_fetch_array($qp)):?>
    <?php $Foto = rb_get_photo_details_from_id($r['image_id']) ?>
    <tr>
      <td><img style="max-width:45px;" src="<?= $Foto['file_url'] ?>" /></td>
      <td><span style="font-size:1.2em"><?= $r['titulo'] ?></span></td>
        <?php
        $i=1;
        while($i<=12):
          $pub_id = $r['id'];
          $current_year = DATE('Y');
          $q = $objDataBase->Consultar("SELECT SUM(cantidad) AS total_cant FROM metro_movimientos WHERE publicacion_id = $pub_id AND mes = $i AND anio = $current_year AND almacen_id = $almacen_id");
          $rp = mysql_fetch_array($q);
          ?>
          <td style="text-align:center"><span style="font-size:1.3em">
          <?= $rp['total_cant'] ?>
          </span></td>
          <?php
          $i++;
        endwhile ?>
    </tr>
    <?php endwhile ?>
  </tbody>
</table>
