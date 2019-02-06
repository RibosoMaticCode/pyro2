<?php if (!in_array("files", $array_help_close)): ?>
<div class="help" data-name="files">
  <h4>Información</h4>
  <p>Puedes subir tus archivos necesarios para asociarlos con los contenidos que generes en el sitio.</p>
</div>
<?php endif ?>
<script>
$(document).ready(function() {
  // SELECT ALL ITEMS CHECKBOXS
  $('#select_all').change(function(){
      var checkboxes = $(this).closest('table').find(':checkbox');
      if($(this).prop('checked')) {
        checkboxes.prop('checked', true);
      } else {
        checkboxes.prop('checked', false);
      }
  });
  // DELETE all
  $('#delete').click(function( event ){
		var len = $('input:checkbox[name=items]:checked').length;
		if(len==0){
			alert("[!] Seleccione un elemento a eliminar");
			return;
		}

    var url;
		var eliminar = confirm("[?] Esta seguro de eliminar los "+len+ " items?");
		if ( eliminar ) {
			$('input:checkbox[name=items]:checked').each(function(){
				item_id = $(this).val();
        var item_li = $(this).closest('li');
        console.log(item_li);
				url = 'core/files/file-del.php?id='+item_id;
				$.ajax({
					url: url,
					cache: false,
					type: "GET"
				}).done(function( data ) {
          if(data.result==1){
            item_li.fadeOut();
          }else{
            notify('Ocurrio un error inesperado. Intente luego.');
            return false;
          }
        });
			});
      notify('Los datos seleccionados fueron eliminados correctamente.');
      /*setTimeout(function(){
        window.location.href = '<?= G_SERVER ?>/rb-admin/index.php?pag=explorer';
      }, 1000);*/
		}
	});
  // DELETE ITEM
  $('.del-item').click(function( event ){
    var item_id = $(this).attr('data-id');
    item_li = $(this).closest('li');
    var eliminar = confirm("[?] Esta a punto de eliminar este dato. Continuar?");

  	if ( eliminar ) {
  		$.ajax({
  			url: 'core/files/file-del.php?id='+item_id,
  			cache: false,
  			type: "GET",
  			success: function(data){
          if(data.result = 1){
            notify('El dato fue eliminado correctamente.');
            item_li.fadeOut();
            /*setTimeout(function(){
              window.location.href = '<?= G_SERVER ?>/rb-admin/index.php?pag=explorer';
            }, 1000);*/
          }else{
            notify('Ocurrio un error inesperado. Intente luego.');
          }
  			}
  		});
  	}
  });

  // show uploader
  $('.show-uploader').click(function( event ){
    $('#uploader').slideToggle();
  });

  // Filter files
  $('#search_box').keyup(function(){
    var valThis = $(this).val();
    $('.gallery>li').each(function(){
      var text = $(this).find('.filename').text().trim().toLowerCase();
      (text.indexOf(valThis) == 0) ? $(this).show() : $(this).hide();
    });
  });
});
</script>
<div id="sidebar-left">
  <ul class="buttons-edition">
    <li><a class="btn-primary show-uploader" href="#"><img src="img/add-white-16.png" alt="Cargar" /> Subir Archivos</a></li>
    <li><a class="btn-delete" rel="files" href="#" id="delete"><img src="img/del-white-16.png" alt="delete" /> Eliminar</a></li>
    <li>
      <input type="text" id="search_box" placeholder="Filtrar por nombre de archivo" />
    </li>
  </ul>
</div>
<!-- plugin uploader -->
<div class="wrap-home">
  <section id="uploader" class="seccion" style="display:none">
    <div class="seccion-header">
      <h3>Subir archivos</h3>
    </div>
    <div class="seccion-body">
    <div id="mulitplefileuploader"></div>
    <span class="info">Archivos permitidos: jpg, png, gif, doc, docx, xls, xlsx, pdf. Tamaño máximo: <strong><?php echo ini_get("upload_max_filesize"); ?></strong></span>
    <div id="status"></div>
    <!-- Load multiples imagenes -->
    <link href="<?= G_SERVER ?>/rb-admin/resource/jquery.file.upload/uploadfile.css" rel="stylesheet">
    <script src="<?= G_SERVER ?>/rb-admin/resource/jquery.file.upload/jquery.uploadfile.js"></script>

    <script type="text/javascript">
    $(document).ready(function(){
      var settings = {
        url: "<?= G_SERVER ?>/rb-admin/uploader.php",
        dragDrop:true,
        fileName: "myfile",
        formData: {"albumid":"0", "user_id" : "<?= G_USERID ?>"},
        urlimgedit: '<?= G_SERVER."/rb-admin/index.php?pag=file_edit&opc=edt&id=" ?>',
        allowedTypes:"jpeg,jpg,png,gif,doc,docx,xls,xlsx,pdf",
        returnType:"json", //html
        showStatusAfterSuccess: false,
        onSuccess:function(files,data,xhr){
          console.log(data);
          $.ajax({
              method: "GET",
              url: "core/files/file-item.php?id="+data.last_id
              //data: $( "#formcat" ).serialize()
          }).done(function( msg ) {
              $('#grid').prepend( msg );
          });
             //$("#status").append("Subido con exito");
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
  </section>
</div>
<!-- plugin uploader -->
<div class="content">
  <div id="content-list">
    <div id="resultado"> <!-- ajax asyncron here -->
      <ul id="grid" class="gallery wrap-grid">
      <?php include('file-list.php') ?>
      </ul>
    </div>
  </div>
</div>
