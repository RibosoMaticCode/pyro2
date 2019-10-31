<?php include_once("../rb-admin/tinymce/tinymce.config.php") ?>
<section class="seccion">
  <div class="seccion-header">
    <?php
    ?>
    <h2>Galeria <?= $_GET['id']?></h2>
  </div>
  <div class="seccion-body">
    <div class="cols-container">
      <div class="cols-6-md">
        <a href="#" id="btnAddBlock" class="button button-sm">Añadir bloque</a>
        <div class="owl_back_list">
          <!--<div class="owl_list_item">
            <span>Bloque</span>
            <div class="owl_block_content">
            </div>
            <a href="#">Editar</a>
            <a href="#">Eliminar</a>
          </div>-->
        </div>
      </div>
      <div class="cols-6-md">
        <label title="Descripcion de la foto">Descripcion:
          <textarea name="title" class="mceEditor" id="editor1" style="width:100%;"><?php if(isset($row))echo $row['title'] ?></textarea>
        </label>
        <input type="hidden" id="block_edit_id" value="" />
        <button id="btnSaveContent" class="button button-sm btn-primary">Guardar contenido</button>
      </div>
    </div>
  </div>
</section>
<script>
$(document).ready(function() {
  // Añadir nuevo block
  var counter = 1;
  $('#btnAddBlock').click(function(event){
    event.preventDefault();
    $('.owl_back_list').append('<div id="'+counter+'" class="owl_list_item">'+
      '<span>Bloque</span>'+
      '<div class="owl_block_content">Puedes empezar a editar'+
      '</div>'+
      '<a class="edit" href="#">Editar</a>'+
      '<a class="delete" href="#">Eliminar</a>'+
      '</div>');
    counter++;
  });

  // ELiminar block
  $('.owl_back_list').on('click', '.delete', function(event){
    event.preventDefault();
    block_id = $(this).closest('.owl_list_item').attr('id');
    $('#'+block_id).remove();
  });

  // Editar block
  $('.owl_back_list').on('click', '.edit', function(event){
    event.preventDefault();
    var block_id = $(this).closest('.owl_list_item').attr('id');
    var content = $('#'+block_id).find('.owl_block_content').html();
    $('#block_edit_id').val(block_id);
    tinymce.activeEditor.setContent(content);
  });

  // Guardar block
  $('#btnSaveContent').click(function(event){
    event.preventDefault();
    var block_id = $('#block_edit_id').val();
    $('#'+block_id).find('.owl_block_content').html(tinymce.activeEditor.getContent());
  });

  // Guardar todos los block
});
</script>
