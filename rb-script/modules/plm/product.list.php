<?php
while ($row = $qlist->fetch_assoc()):
  $photo = rb_get_photo_details_from_id($row['foto_id']);
  $category = get_category_info($row['categoria']);
  ?>
	<tr>
		<td><img style="max-width:50px" src="<?= $photo['thumb_url'] ?>" alt="imagen" /></td>
    <td><?= $row['nombre'] ?></td>
		<td><a target="_blank" href="<?= $category['url'] ?>"><?= $category['nombre'] ?></a></td>
    <td><?= $row['precio_oferta'] ?></td>
    <td><?= $row['descuento'] ?> %</td>
    <td><?= $row['precio'] ?></td>
    <td><?= rb_link_gallery($row['galeria_id']) ?></td>
		<td class="row-actions">
      <?php
      if(G_ENL_AMIG) $product_url = G_SERVER."/products/".$row['nombre_key']."/";
			else $product_url = G_SERVER."/?products=".$row['id'];
      ?>
      <a title="Previsualizar" class="edit" href="<?= $product_url ?>" target="_blank">
        <i class="fa fa-external-link-alt"></i>
      </a>
      <a title="Editar" class="edit" data-item="<?= $row['id'] ?>" href="<?= G_SERVER ?>/rb-admin/module.php?pag=plm_products&product_id=<?= $row['id'] ?>">
        <i class="fa fa-edit"></i>
      </a>
      <a title="Click para cambiar" class="change_view" href="#" data-item="<?= $row['id'] ?>" data-value="<?php if($row['mostrar']==1) echo "0"; else echo "1" ?>">
      <?php if($row['mostrar']==1): ?>
          <i class="fa fa-eye"></i>
      <?php else: ?>
          <i class="fa fa-eye-slash"></i>
      <?php endif; ?>
      </a>
      <a title="Eliminar" class="del" data-item="<?= $row['id'] ?>" href="#">
        <i class="fa fa-times"></i>
      </a>
    </td>
	</tr>
  <?php
endwhile;
?>
<script>
$(document).ready(function() {
  $('.change_view').click( function(event){
    var element = $(this);
    var id = $(this).attr('data-item');
    var value = $(this).attr('data-value');
    $.ajax({
      type: "GET",
      url: "<?= G_SERVER ?>/rb-script/modules/plm/product.change.php?id="+id+"&value="+value
    })
    .done(function( data ) {
      if(data.resultado){
        notify(data.contenido);
        if(data.show==1){
          element.html('<i class="fa fa-eye"></i>');
          element.attr('data-value', '0');
        }else{
          element.html('<i class="fa fa-eye-slash"></i>');
          element.attr('data-value', '1');
        }
      }else{
        notify(data.contenido);
      }
    });
  });
});
</script>
