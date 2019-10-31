<?php
while ($row = $qlist->fetch_assoc()):
  $product= get_product_info($row['product_id']);
  if(!$product){
    $product['url'] = "#";
    $product['nombre'] = "[Producto ya no existe]";
  }
  $user = rb_get_user_info($row['user_id']);
  ?>
	<tr>
    <td>
      <a title="ID <?= $row['id'] ?>" target="_blank" href="<?= $product['url'] ?>"><?= $product['nombre'] ?></a>
    </td>
    <td>
      <?= rb_sqldate_to($row['date_register'], 'd-m-Y') ?><br />
      <?= rb_sqldate_to($row['date_register'], 'h:i') ?>
    </td>
    <td>
      <strong><?= $row['title'] ?></strong>
      <div>
        <?= $row['comment'] ?>
      </div>
      <div id="cover_imgs_<?= $row['id'] ?>" data-id="<?= $row['id'] ?>" class="review-imgs">
        <?php
        if($row['img_ids']!=""):
          $img_ids = explode(",", $row['img_ids']);
          foreach ($img_ids as $img_id) {
            $photo = rb_get_photo_details_from_id($img_id);
            ?>
            <div id="previmg_<?= $img_id ?>" data-id="<?= $img_id ?>">
              <a class="fancybox" data-fancybox-group="gallery_<?= $row['id']?>" href="<?= $photo['file_url']?>"><img src="<?= $photo['thumb_url'] ?>" alt="thumb" /></a>
              <a href="#" class="remove-img">Remover</a>
            </div>
            <?php
          }
        endif;
        ?>
      </div>
    </td>
    <td>
      <?= $row['score'] ?>
    </td>
    <td>
      <a title="Click para cambiar" class="change_view" href="#" data-item="<?= $row['id'] ?>" data-value="<?php if($row['state']==1) echo "0"; else echo "1" ?>">
      <?php
      if($row['state']==0){
        ?>
        Pendiente aprobación
        <?php
      }elseif($row['state']==1){
        ?>
        Aprobado
        <?php
      }
      ?>
      </a>
    </td>
    <td>
      <a href="<?= G_SERVER ?>rb-admin/index.php?pag=usu&opc=edt&id=<?= $row['user_id'] ?>"><?= $user['nickname'] ?></a>
    </td>
		<td class="row-actions">
      <a title="Editar" class="edit fancyboxForm fancybox.ajax" data-item="<?= $row['id'] ?>" href="<?= $newedit_path ?>?id=<?= $row['id'] ?>">
        <i class="fa fa-edit"></i>
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
  // Aprobar / desaprobar reseña
  $('.change_view').click( function(event){
    var element = $(this);
    var id = $(this).attr('data-item');
    var value = $(this).attr('data-value');
    $.ajax({
      type: "GET",
      url: "<?= G_SERVER ?>rb-script/modules/plm/review.change.php?id="+id+"&value="+value+"&field=state"
    })
    .done(function( data ) {
      if(data.resultado){
        notify(data.contenido);
        if(data.show==1){
          element.html('Aprobado');
          element.attr('data-value', '0');
        }else{
          element.html('Pendiente aprobación');
          element.attr('data-value', '1');
        }
      }else{
        notify(data.contenido);
      }
    });
  });

  // Remove imagen in form
  var img_ids = [];
  $( ".remove-img" ).click(function(event) {
    event.preventDefault();
    var eliminar = confirm("¿Continuar con la eliminacion de este elemento?");
    if ( eliminar ) {
      var photo_id = $(this).closest('div').attr('data-id');
      var cover_id = $(this).closest('.review-imgs').attr('data-id');
      console.log("b:"+cover_id);
      $.ajax({
        method: "get",
        url: "<?= G_SERVER ?>rb-admin/core/files/file-del.php?id="+photo_id
      })
      .done(function( data ) {
        if(data.result){
          $('#previmg_'+photo_id).remove();
          // Volver a contar las imagenes, y actualizar conteo en campo img_ids
          console.log(cover_id);
          img_ids = [];
          $("#cover_imgs_"+cover_id+" div").each(function(){
            img_ids.push( $(this).attr('data-id') );
          });
          console.log(img_ids);
          $.ajax({
            type: "GET",
            url: "<?= G_SERVER ?>rb-script/modules/plm/review.change.php?id="+cover_id+"&value="+img_ids+"&field=img_ids"
          })
          .done(function( data ) {
            if(!data.result){
              alert(data.contenido);
            }
          });
        }else{
          alert(data.message);
        }
      });
    }
  });
});
</script>
