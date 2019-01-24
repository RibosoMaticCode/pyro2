<?php
$title_section = "Movimientos de pedidos";
$file_prefix = "live";
$module_dir = "restaurant";

$atendido_path = G_DIR_MODULES_URL.$module_dir."/".$file_prefix.".plato.atendido.php";
$atendido_todo_path = G_DIR_MODULES_URL.$module_dir."/".$file_prefix.".pedido.atendido.php";
$documento_path = G_DIR_MODULES_URL.$module_dir."/document.php";
$urlreload=G_SERVER.'/rb-admin/module.php?pag=rest_pedido_live';
$anular_path = G_DIR_MODULES_URL.$module_dir."/pedido.anular.php";

if(isset($_GET['date'])){
  $fecha_pedido = $_GET['date'];
}else{
  $fecha_pedido = date('Y-m-d');
}
$objDataBase = new DataBase;
$qp = $objDataBase->Ejecutar("SELECT * FROM rest_pedido WHERE date(fecha_registro) ='".$fecha_pedido."' ORDER BY fecha_registro DESC");

require_once 'funcs.php';
?>
<section class="seccion">
  <div class="seccion-header">
    <h2><?= $title_section ?></h2>
  </div>
  <div class="seccion-body">
    <div class="pedido_live">
      <div class="cols-container pedido_top_info">
        <div class="cols-6-md info_left">
          Fecha
          <input type="date" name="fecha" value="<?= $fecha_pedido ?>" id="fecha_pedido" />
          <script>
          $('input[name=fecha]').change(function() {
            console.log($(this).val());
            window.location.href = '<?= $urlreload ?>&date='+$(this).val();
          });
          </script>
        </div>
        <div class="cols-6-md info_right">
          <?php
          // Consultar el total de pedidos de dia
          $qt = $objDataBase->Ejecutar("SELECT SUM(total) AS totales FROM rest_pedido WHERE date(fecha_registro) ='".$fecha_pedido."' AND estado=2"); // Pedido de la fecha atendidos
          $pedido_total = $qt->fetch_assoc();
          ?>
          <h1>S/.  <?= $pedido_total['totales'] ?></h1>
        </div>
      </div>
      <table class="rest_tables">
        <?php while ($pedido = $qp->fetch_assoc()){ ?>
        <tr>
          <td class="align_left">
            <div class="cols-container">
              <div class="cols-6-md">
                Pedido ID: <strong><?= $pedido['id'] ?></strong> <br />
                Fecha / Hora: <strong><?= rb_sqldate_to($pedido['fecha_registro'], 'd-m-Y / H:i:s') ?></strong> <br />
                Mesa: <strong><?= mesa($pedido['mesa_id'], 'nombre') ?></strong> <br />
              </div>
              <div class="cols-6-md block_right">
                <?php if($pedido['estado']==0): ?>
                  <h1 style="color:red">ANULADO</h1>
                <?php endif ?>
                <?php if($pedido['estado']==1): ?>
                  <h1 style="color:ambar">EN PROCESO</h1>
                  <a class="atendido_todo" data-pedidoid="<?= $pedido['id'] ?>" href="#">Marcar como atendido todo el pedido</a>
                  <a class="anular_pedido" data-pedidoid="<?= $pedido['id'] ?>" href="#">Anular</a>
                  <script>

                  </script>
                <?php endif ?>
                <?php if($pedido['estado']==2): ?>
                  <h1 style="color:green">ATENDIDO</h1>
                  <a target="_blank" href="<?= $documento_path ?>?pedido_id=<?= $pedido['id'] ?>">Ver documento</a>
                <?php endif ?>
              </div>
            </div>
            <table class="rest_tables">
              <tr>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th class="plato_nombre">Plato</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Acciones</th>
              </tr>
              <?php
              $qpd = $objDataBase->Ejecutar("SELECT * FROM rest_pedido_detalles WHERE pedido_id =".$pedido['id']);
              while( $detalle = $qpd->fetch_assoc() ){?>
                <tr>
                  <td>
                    <?= rb_sqldate_to($detalle['hora_inicio'], 'H:i:s') ?>
                  </td>
                  <td>
                    <?= rb_sqldate_to($detalle['hora_termino'], 'H:i:s') ?>
                  </td>
                  <td class="align_left">
                    <?= plato($detalle['plato_id'], 'nombre') ?>
                  </td>
                  <td>
                    <?= $detalle['cantidad'] ?>
                  </td>
                  <td>
                    <?= $detalle['precio'] ?>
                  </td>
                  <td>
                    <?php if($detalle['hora_termino']=='0000-00-00 00:00:00' && $detalle['estado']!=0): ?>
                      <a data-pedidoid="<?= $pedido['id'] ?>" data-platoid="<?= $detalle['plato_id'] ?>" class="atendido" href="#">Atendido</a>
                    <?php elseif($detalle['estado']==0): ?>
                      Anulado
                    <?php else: ?>
                      Atendido
                    <?php endif ?>
                  </td>
                </tr>
              <?php } ?>
            </table>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>
  </div>
</section>
<script>
    // Marcar como atendio cada plato
    $(".atendido").click(function(event){
      var atendido = confirm("¿El plato ha sido atendido?");
      if ( atendido ) {
        var pedido_id = $(this).attr('data-pedidoid');
        var plato_id = $(this).attr('data-platoid');
        url = '<?= $atendido_path ?>?pedido_id='+pedido_id+'&plato_id='+plato_id;
        $.ajax({
          url: url,
          cache: false,
          type: "GET"
        }).done(function( data ) {
          if(data.resultado){
            notify(data.contenido);
            setTimeout(function(){
  						window.location.href = '<?= $urlreload ?>';
  					}, 1000);
          }else{
            notify(data.contenido);
            return false;
          }
        });
      }
    });

    // Marcar como atendio todo el pedido
    $(".atendido_todo").click(function(event){
      var atendido = confirm("¿Marcar todo el pedido como atendido?");
      if ( atendido ) {
        var pedido_id = $(this).attr('data-pedidoid');
        url = '<?= $atendido_todo_path ?>?pedido_id='+pedido_id;
        $.ajax({
          url: url,
          cache: false,
          type: "GET"
        }).done(function( data ) {
          if(data.resultado){
            notify(data.contenido);
            setTimeout(function(){
  						window.location.href = '<?= $urlreload ?>';
  					}, 1000);
          }else{
            notify(data.contenido);
            return false;
          }
        });
      }
    });

    // ANULADO PEDIDO
    // =======================================
    $('.anular_pedido').click(function (event){
      event.preventDefault();
      var anula = confirm("¿Confirma anulacion del pedido?");
      if ( anula ) {
        var pedido_id = $(this).attr('data-pedidoid');
        $.ajax({
          method: "get",
          url: "<?= $anular_path ?>?pedido_id="+pedido_id,
          cache: false
        })
        .done(function( data ) {
          if(data.resultado){
            $.fancybox.close();
            notify(data.contenido);
            setTimeout(function(){
              window.location.href = '<?= $urlreload ?>';
            }, 1000);
          }else{
            notify(data.contenido);
          }
        });
      }
    });
</script>
