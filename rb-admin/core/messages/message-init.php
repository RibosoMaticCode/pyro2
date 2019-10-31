<?php if (!in_array("men", $array_help_close)): ?>
<div class="help" data-name="men">
  <h4>Información</h4>
  <p>Puede enviar y recibir notificaciones de otros usuario del sistema. Funciona similar a una bandeja de correo electrónico, muy básica</p>
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

		var eliminar = confirm("[?] Esta seguro de eliminar los "+len+ " items?");
		if ( eliminar ) {
			$('input:checkbox[name=items]:checked').each(function(){
				var item_id = $(this).val();
        var mode = $(this).attr('data-mode');
        var uid = $(this).attr('data-uid');
				$.ajax({
					url: 'core/messages/message-del.php?id='+item_id+'&mode='+mode+'&uid='+uid,
					cache: false,
					type: "GET"
				}).done(function( data ) {
          if(data.result==0){
            notify('Datos eliminados, pero algun que otro no, revise');
            return false;
          }
        });
			});
      notify('Los datos seleccionados fueron eliminados correctamente.');
      setTimeout(function(){
        if(mode == "rd"){
          window.location.href = '<?= G_SERVER ?>rb-admin/index.php?pag=men';
        }
        if(mode == "sd"){
          window.location.href = '<?= G_SERVER ?>rb-admin/index.php?pag=men&opc=send';
        }
      }, 1000);
		}
	});
  // DELETE ITEM
  $('.del-item').click(function( event ){
    var item_id = $(this).attr('data-id');
    var mode = $(this).attr('data-mode');
    var uid = $(this).attr('data-uid');

    var eliminar = confirm("[?] Esta a punto de eliminar este usuario. Continuar?");

  	if ( eliminar ) {
  		$.ajax({
  			url: 'core/messages/message-del.php?id='+item_id+'&mode='+mode+'&uid='+uid,
  			cache: false,
  			type: "GET",
  			success: function(data){
          if(data.result == 1){
            notify('El dato fue eliminado correctamente.');
            setTimeout(function(){
              if(mode == "rd"){
                window.location.href = '<?= G_SERVER ?>rb-admin/index.php?pag=men';
              }
              if(mode == "sd"){
                window.location.href = '<?= G_SERVER ?>rb-admin/index.php?pag=men&opc=send';
              }
            }, 1000);
          }else{
            notify(data.message);
          }
  			}
  		});
  	}
  });
});
</script>
<div class="wrap-content-list">
  <section class="seccion">
    <div class="seccion-header">
      <h2>Mensajeria</h2>
      <ul class="buttons">
        <li><a class="button btn-primary" href="<?= G_SERVER ?>rb-admin/?pag=men&opc=nvo"><i class="fa fa-plus-circle"></i> <span class="button-label">Nuevo</span></a></li>
        <li><a class="button" <?= $style_btn_default ?>href="<?= G_SERVER ?>rb-admin/?pag=men"> <span class="button-label">Recibidos</span></a></li>
        <li><a class="button" <?= $style_btn_1 ?>href="<?= G_SERVER ?>rb-admin/?pag=men&opc=send"> <span class="button-label">Enviados</span></a></li>
        <li><a class="button btn-delete" href="#" id="delete"><i class="fa fa-times"></i> <span class="button-label">Eliminar</span></a></li>
      </ul>
    </div>
    <div class="seccion-body">
      <div id="content-list">
        <div id="resultado">
          <script>
            $(document).ready(function() {
              $('#table').DataTable({
                "language": {
                  "url": "resource/datatables/Spanish.json"
                }
              });
            } );
          </script>
          <table id="table" class="tables table-striped">
            <thead>
              <tr>
                <th><input type="checkbox" value="all" id="select_all" /></th>
                <th>Asunto</th>
                <?php if(isset($_GET['opc']) && $_GET['opc'] =="send"){ ?> <th>Destinatarios</th>
                <?php }else{ ?> <th>Remitente</th><?php } ?>
                <th>Fecha</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php include('message-list.php') ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>
