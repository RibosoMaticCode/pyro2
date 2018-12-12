<?php
// Valores iniciales
$rb_module_title = "Grupos";
$rb_module_title_section = "Grupos";
$rb_module_path = "Inicio > Grupos";
$rb_module_url_main = G_SERVER."/rb-admin/index.php";
$rb_module_url = G_SERVER."/rb-admin/core/grupos/";
$rb_module_url_img = "";

// Menu
rb_add_specific_item_menu('users', array(
			'key' => 'gru',
			'nombre' => "Grupos",
			'url' => "module.php?pag=gru",
			'url_imagen' => "none",
			'pos' => 1
	));

if(isset($_GET['pag']) && $_GET['pag']=="gru"):
	if($userType != "admin"):
		printf(" No tiene permiso de Administrador ");
		die;
	endif;
	// Contenido inicial
	function group_admin_content(){
		if(isset($_GET['opc'])):
			$opc=$_GET['opc'];
			include('group.edit.php');
		else:
		?>
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
						url = 'core/grupos/group.delete.php?id='+item_id;
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
		        window.location.href = '<?= G_SERVER ?>/rb-admin/module.php?pag=gru';
		      }, 1000);
				}
			});
		  // DELETE ITEM
		  $('.del-item').click(function( event ){
		    var item_id = $(this).attr('data-id');
		    var eliminar = confirm("[?] Esta a punto de eliminar este dato. Continuar?");

		  	if ( eliminar ) {
		  		$.ajax({
		  			url: 'core/grupos/group.delete.php?id='+item_id,
		  			cache: false,
		  			type: "GET",
		  			success: function(data){
		          if(data.result = 1){
		            notify('El dato fue eliminado correctamente.');
		            setTimeout(function(){
		              window.location.href = '<?= G_SERVER ?>/rb-admin/module.php?pag=gru';
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
				<div class="seccion-header">
					<h2>Grupos</h2>
					<ul class="buttons">
						<li><a class="btn-primary" href="<?= G_SERVER ?>/rb-admin/module.php?pag=gru&amp;opc=nvo"><i class="fa fa-plus-circle"></i> <span class="button-label">Nuevo</span></a></li>
						<li><a class="btn-delete" href="#" id="delete"><i class="fa fa-times"></i> <span class="button-label">Eliminar</span></a></li>
					</ul>
				</div>
				<div class="seccion-body">
				<table class="tables">
					<thead>
						<tr>
							<th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
							<th>Grupo</th>
						</tr>
					</thead>
					<tbody>
						<?php include('group.list.php') ?>
					</tbody>
				</table>
				</div>
			</section>
		</div>
	<?php
		endif;
	}

	add_function('module_content_main','group_admin_content');
endif;
//$sec="nivel";
?>
