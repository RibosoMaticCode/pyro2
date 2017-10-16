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
		<div id="sidebar-left">
			<ul class="buttons-edition">
				<li><a class="btn-primary" href="../rb-admin/module.php?pag=gru&amp;opc=nvo"><img src="img/add-white-16.png" alt="Nuevo"> Nuevo</a></li>
				<li><a class="btn-primary" href="#" id="delete"><img src="img/del-white-16.png" alt="delete"> Eliminar</a></li>
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
				<table class="tables" border="0" cellpadding="0" cellspacing="0">
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
			</section>
		</div>
	<?php
		endif;
	}

	add_function('module_content_main','group_admin_content');
endif;
//$sec="nivel";
?>
