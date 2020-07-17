<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';

if(isset($_GET["id"]) && $_GET["id"] > 0){
  $id=$_GET["id"];
  $cons = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."menus WHERE id=".$id);
  $row= $cons->fetch_assoc();
}else{
  $id=0;
}
?>
<form id="frmNewEditMenu" class="form" name="categorie-form" method="post" action="core/menu/menu-save.php">
  <input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
  <label title="Nombre del Menu" for="nombre">Nombre del Menu:
    <input required  name="nombre" type="text" value="<?php if(isset($row))echo $row['nombre'] ?>" />
  </label>
  <label>
    <input name="tipo" type="checkbox" <?php if(isset($row) && $row['tipo'] == 1) echo "checked"; ?> /> Menu principal
  </label>
  <div class="cols-container">
    <div class="cols-6-md cols-content-left">
      <button type="submit" class="button btn-primary">Guardar</button>
    </div>
    <div class="cols-6-md cols-content-right">
      <button type="button" class="button CancelFancyBox">Cancelar</button>
    </div>
  </div>
</form>
<script>
// Boton Guardar
$(document).on("submit","#frmNewEditMenu",function(event){
  event.preventDefault();
  //tinyMCE.triggerSave(); //save first tinymce en textarea
  $.ajax({
    method: "post",
    url: "<?= G_SERVER ?>rb-admin/core/menu/menu-save.php",
    data: $( this ).serialize()
  })
  .done(function( data ) {
    if(data.resultado){
      $.fancybox.close();
      notify(data.contenido);
      setTimeout(function(){
        window.location.href = '<?= G_SERVER ?>rb-admin/index.php?pag=menus';
      }, 1000);
    }else{
      notify(data.contenido);
    }
  });
});

// Boton Cancelar
$(document).on("click",".CancelFancyBox",function(event){
  $.fancybox.close();
});
</script>
