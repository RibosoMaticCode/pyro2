<div class='panel pedidos_panel'>
  <h3>Pedidos</h3>
  <table class="tables">
    <tr>
      <th>Codigo Pedido</th>
      <th>Fecha registro</th>
      <th>ID del cargo</th>
      <th>Detalle</th>
      <th><?= G_COIN ?>Total</th>
    </tr>
    <?php
    global $objDataBase;
    $qp = $objDataBase->Ejecutar("SELECT * FROM plm_orders WHERE user_id=".G_USERID." ORDER BY id DESC");
    while($pedido = $qp->fetch_assoc()):
      ?>
      <tr>
        <td><?= $pedido['codigo_unico']?></td>
        <td><?= rb_sqldate_to($pedido['fecha_registro'], 'd-m-Y / H:i') ?></td>
        <td><?= $pedido['charge_id']?></td>
        <td><a href="#" class="view_order">Ver detalle del pedido</a>
          <div class="details" style="display:none">
            <?= $pedido['detalles']?>
          </div>
        </td>
        <td><?= G_COIN ?> <?= number_format($pedido['total'], 2) ?></td>
      </tr>
      <?php
    endwhile;
    ?>
  </table>
</div>
<script>
$(document).ready(function() {
  $( ".bg" ).click(function(event) {
    event.preventDefault();
    $(".bg").fadeOut();
    $(".winfloat").hide();
  });

  $('.view_order').click( function(event){
    event.preventDefault();
    console.log($(this).next('.details').html());
    var content_details = $(this).next('.details').html();
    $(".winfloat").html(content_details);
    $( ".bg" ).show();
    $( ".winfloat" ).show();
  });
})
</script>
