<?php
function rb_content_salidas(){
  global $rb_module_url_main;
  $rb_module_url = G_SERVER."/rb-script/modules/metro/";
  $urlreload = G_SERVER."/rb-admin/module.php?pag=predi_sal";
  ?>
  <div class="help" data-name="predi_sal">
    <h4>Información</h4>
    <p>Reportes de salidas de publicaciones totales y por almacen. Como tambien detalles de las respecivas salidas.</p>
    <a id="help-close" class="help-close" href="#">X</a>
  </div>
  <!--<div id="sidebar-left">
    <ul class="buttons-edition">
      <li><a class="fancybox fancybox.ajax btn-primary" href="<?= $rb_module_url ?>almacen.frm.php"><img src="img/add-white-16.png" alt="Nuevo"> Nuevo</a></li>
    </ul>
  </div>-->
  <?php

  if ( !defined('ABSPATH') )
  	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

  require_once(ABSPATH.'global.php');
  require_once ABSPATH.'rb-script/class/rb-database.class.php';


  ?>
  <div class="wrap-content-list">
    <section class="seccion">
      <div class="seccion-header">
        <h3>Totales por mes</h3>
      </div>
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
          //$qp = $objDataBase->Consultar("select mp.id, mp.titulo, mp.codigo, mp.image_id, IFNULL(SUM(mm.cantidad),0) as sal_cantidad from metro_publicacion mp left join metro_movimientos mm on mp.id = mm.publicacion_id AND mm.tipo = 'SAL' GROUP BY mp.id");
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
                $q = $objDataBase->Consultar("SELECT SUM(cantidad) AS total_cant FROM metro_movimientos WHERE publicacion_id = $pub_id AND mes = $i AND anio = $current_year");
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
    </section>

    <section class="seccion">
      <div class="seccion-header">
        <h3>Salidas por Punto de Predicación / Almacen</h3>
      </div>
      <div class="seccion-body">
        <div class="cols-container">
          <div class="cols-6-md">
            <label>Seleccionar Punto Predicacion /Almacen</label>
          </div>
          <div class="cols-6-md">
            <form>
              <label>
                <select id="almacen_id" name="almacen_id">
                  <option value="0">[Seleccione para ver]</option>
                  <?php
                  $qph = $objDataBase->Consultar("SELECT mp.id, mp.descripcion, ma.nombre_almacen, ma.id FROM metro_puntos mp, metro_almacen ma WHERE mp.almacen_id = ma.id");
                  while($puntos = mysql_fetch_array($qph)):?>
        						<option value="<?= $puntos['id'] ?>"><?= $puntos['descripcion'] ?> - <?= $puntos['nombre_almacen'] ?></option>
        					<?php endwhile ?>
                <select/>
              </label>
            </form>
          </div>
        </div>
        <script type="text/javascript">
    			$(document).ready(function () {
            $('#almacen_id').change(function (event){
              var valueSelected = this.value;

              $.ajax({
                method: "GET",
                data: "almacen_id="+valueSelected,
                url: "<?= $rb_module_url ?>salidas.almacen.php",
                success: function(data){
                  $('#result_almacen').html(data);
                }
              });
            });
          });
        </script>
        <div id="result_almacen">

        </div>
      </div>
    </section>
  </div>
  <?php
}
add_function('module_content_main','rb_content_salidas');
?>
