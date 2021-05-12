<?php
while ($row = $qlist->fetch_assoc()):
  ?>
	<tr>
    <td><?= $row['id'] ?></td>
		<td><?= $row['codigo_unico'] ?></td>
    <td><?= $row['fecha_registro'] ?></td>
    <td><?= $row['user_id'] ?></td>
    <td><?= $row['total'] ?></td>
    <td><?= $row['charge_id'] ?></td>
    <td><?= $row['forma_pago'] ?></td>
    <td><?= $row['detalles'] ?></td>
		<!--<td class="row-actions">
      <a title="Previsualizar" class="edit" href="<?= $product_url ?>" target="_blank">
        <i class="fa fa-external-link-alt"></i>
      </a>
      <a title="Eliminar" class="del" data-item="<?= $row['id'] ?>" href="#">
        <i class="fa fa-times"></i>
      </a>
    </td>-->
	</tr>
  <?php
endwhile;
?>
<script>
$(document).ready(function() {
  $('.view').click( function(event){
    var element = $(this);
    var id = $(this).attr('data-item');
    var value = $(this).attr('data-value');
    $.ajax({
      type: "GET",
      url: "<?= G_SERVER ?>rb-script/modules/plm/product.change.php?id="+id+"&value="+value
    })
    .done(function( data ) {
      if(data.resultado){
        notify(data.contenido);
      }else{
        notify(data.contenido);
      }
    });
  });
});
</script>
