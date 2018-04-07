<h2 class="title">Niveles de acceso</h2>
<?php
$sec="nivel";
if(isset($_GET['opc'])):
	$opc=$_GET['opc'];
	include('niveles.edit.php');
else:
?>
<div id="sidebar-left">
	<ul class="buttons-edition">
		<li><a class="btn-primary" href="../rb-admin/?pag=nivel&amp;opc=nvo"><img src="img/add-white-16.png" alt="Nuevo"> Nuevo</a></li>
		<li><a class="btn-delete" href="#" id="delete"><img src="img/del-white-16.png" alt="delete"> Eliminar</a></li>
	</ul>
</div>
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
				item_id = $(this).val();
				url = 'core/niveles/niveles.delete.php?id='+item_id;
				$.ajax({
					url: url,
					cache: false,
					type: "GET"
				}).done(function( data ) {
          if(data.result==0){
            notify('Ocurrio un error inesperado. Intente luego.');
            return false;
          }
        });
			});
      notify('Los datos seleccionados fueron eliminados correctamente.');
      setTimeout(function(){
        window.location.href = '<?= G_SERVER ?>/rb-admin/index.php?pag=nivel';
      }, 1000);
		}
	});
  // DELETE ITEM
  $('.del-item').click(function( event ){
    var item_id = $(this).attr('data-id');
    var eliminar = confirm("[?] Esta a punto de eliminar este dato. Continuar?");

  	if ( eliminar ) {
  		$.ajax({
  			url: 'core/niveles/niveles.delete.php?id='+item_id,
  			cache: false,
  			type: "GET",
  			success: function(data){
          if(data.result = 1){
            notify('El dato fue eliminado correctamente.');
            setTimeout(function(){
              window.location.href = '<?= G_SERVER ?>/rb-admin/index.php?pag=nivel';
            }, 1000);
          }else{
            notify('Ocurrio un error inesperado. Intente luego.');
          }
  			}
  		});
  	}
  });
});
</script>
<div class="wrap-content-list">
	<section class="seccion">
		<table class="tables" border="0" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
					<th>Nombre</th>
					<th>Nivel key</th>
					<th>Sub-Nivel key</th>
					<th>Detalles</th>
				</tr>
			</thead>
			<tbody>
				<?php include('niveles.list.php') ?>
			</tbody>
		</table>
	</section>
</div>
<?php
endif;
?>
