<?php if (!in_array("files", $array_help_close)): ?>
<div class="help" data-name="files">
  <h4>Información</h4>
  <p>Puedes subir tus archivos necesarios para asociarlos con los contenidos que generes en el sitio.</p>
</div>
<?php endif ?>
<section class="seccion">
  <div class="seccion-header">
    <h2>Explorador de archivos</h2>
    <ul class="buttons">
      <li><a class="button btn-primary show-uploader" href="#"><i class="fa fa-plus-circle"></i> <span class="button-label"> <span class="button-label">Subir archivo</a></li>
      <li><a class="button btn-delete" rel="files" href="#" id="delete"><i class="fa fa-times"></i> <span class="button-label">Eliminar</span></a></li>
    </ul>
  </div>
  <div class="seccion-body">
    <!-- plugin start -->
    <div id="uploader" class="seccion" style="display:none">
      <div id="mulitplefileuploader"></div>
      <span class="info">Archivos permitidos: <?= rb_get_values_options('files_allowed') ?>. Tamaño máximo: <strong><?php echo ini_get("upload_max_filesize"); ?></strong></span>
      <div id="status"></div>
      <!-- Load multiples imagenes -->
      <link href="<?= G_SERVER ?>rb-admin/resource/jquery.file.upload/uploadfile.css" rel="stylesheet">
      <script src="<?= G_SERVER ?>rb-admin/resource/jquery.file.upload/jquery.uploadfile.js"></script>

      <script type="text/javascript">
      $(document).ready(function(){
        var settings = {
          url: "<?= G_SERVER ?>rb-admin/uploader.php",
          dragDrop:true,
          fileName: "myfile",
          formData: {"albumid":"0", "user_id" : "<?= G_USERID ?>"},
          //urlimgedit: '<?= G_SERVER."/rb-admin/index.php?pag=file_edit&opc=edt&id=" ?>',
          allowedTypes:"<?= rb_get_values_options('files_allowed') ?>",
          returnType:"json", //html
          showStatusAfterSuccess: false,
          onSuccess:function(files,data,xhr){
            console.log(data);
            if(data.resultado){
              $.ajax({
                  method: "GET",
                  url: "core/files/file-item.php?id="+data.last_id
              }).done(function( msg ) {
                  $('#grid').prepend( msg );
              });
            }else{
              notify('Error al intentar subir el archivo. <br />Detalles:'+data.contenido);
            }
          },
          //showDelete:true,
          deleteCallback: function(data,pd){
            for(var i=0;i<data.length;i++){
              $.post("delete.php",{op:"delete",name:data[i]},
              function(resp, textStatus, jqXHR){
                $("#status").append("<div>Archivo borrado</div>");
              });
            }
            pd.statusbar.hide(); //You choice to hide/not.
          }
        }
        var uploadObj = $("#mulitplefileuploader").uploadFile(settings);
      });
      </script>
    </div>
    <!-- plugin end -->
    <div class="form">
      <input type="text" id="search_box" placeholder="Filtrar por nombre de archivo" />
    </div>
    <div id="content-list">
      <div id="resultado"> <!-- ajax asyncron here -->
        <ul id="grid" class="gallery wrap-grid">
        <?php include('file-list.php') ?>
        </ul>
      </div>
    </div>
  </div>
</section>
<!-- javascript -->
<script src="<?= G_SERVER ?>rb-admin/core/files/funcs.js"></script>
