<div class="wrap-home">
  <section class="seccion">
    <div class="seccion-header">
      <h3>Subir archivos</h3>
    </div>
    <div class="seccion-body">
    <!--<h2>Subir archivos <sup class="required">*</sup> a la Biblioteca de Medios: [<a href="<?= G_SERVER ?>/rb-admin/index.php?pag=files">Volver</a>]</h2>-->
    <ul class="buttons-edition">
      <li><a href="<?= G_SERVER ?>/rb-admin/index.php?pag=files" class="btn-primary">Volver</a></li>
    </ul>

    <div id="mulitplefileuploader"></div>
    <span class="info">Archivos permitidos: jpg, png, gif, doc, docx, xls, xlsx, pdf. Tamaño máximo: 8 MB</span>
    <div id="status"></div>
    <!-- Load multiples imagenes -->
    <link href="<?= G_SERVER ?>/rb-admin/resource/jquery.file.upload/uploadfile.css" rel="stylesheet">
    <script src="<?= G_SERVER ?>/rb-admin/resource/jquery.file.upload/jquery.uploadfile.js"></script>

    <script type="text/javascript">
    $(document).ready(function(){
      var settings = {
          url: "upload.php",
          dragDrop:true,
          fileName: "myfile",
          formData: {"albumid":"0", "user_id" : "<?= G_USERID ?>"},
          urlimgedit: '<?= G_SERVER."/rb-admin/index.php?pag=file_edit&opc=edt&id=" ?>',
          allowedTypes:"jpg,png,gif,doc,docx,xls,xlsx,pdf",
          returnType:"html", //json
        onSuccess:function(files,data,xhr)
          {
             //$("#status").append("Subido con exito");
          },
          //showDelete:true,
          deleteCallback: function(data,pd)
        {
          for(var i=0;i<data.length;i++)
          {
              $.post("delete.php",{op:"delete",name:data[i]},
              function(resp, textStatus, jqXHR)
              {
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
