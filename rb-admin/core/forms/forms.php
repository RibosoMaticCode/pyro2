<?php
// Menu
rb_add_specific_item_menu('visual', array(
			'key' => 'forms',
			'nombre' => "Formularios",
			'url' => "module.php?pag=forms"
));

if(isset($_GET['pag']) && $_GET['pag']=="forms"):
	// Titulo de pagina
	function forms_title(){
		return "Editor de formularios";
	}
	add_function('module_title_page','forms_title');
	// Permisos
	if($userType != "admin"):
		printf(" No tiene permiso de Administrador ");
		die;
	endif;

	// Function
	function forms_editor(){
		global $objDataBase;
		?>
		<div class="page-header">
			<h2>Seudo editor de formularios</h2>
		</div>
		<?php
		if(isset($_GET['opc'])):
			$opc=$_GET['opc'];
			include('forms.edit.php');
		else:
		?>
		<div id="sidebar-left">
			<ul class="buttons-edition">
				<li><a class="btn-primary" href="../rb-admin/module.php?pag=forms&amp;opc=nvo"><img src="img/add-white-16.png" alt="Nuevo"> Nuevo</a></li>
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
						url = 'core/forms/forms.delete.php?id='+item_id;
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
		        window.location.href = '<?= G_SERVER ?>/rb-admin/module.php?pag=forms';
		      }, 1000);
				}
			});
		  // DELETE ITEM
		  $('.del-item').click(function( event ){
		    var item_id = $(this).attr('data-id');
		    var eliminar = confirm("[?] Esta a punto de eliminar este dato. Continuar?");

		  	if ( eliminar ) {
		  		$.ajax({
		  			url: 'core/forms/forms.delete.php?id='+item_id,
		  			cache: false,
		  			type: "GET",
		  			success: function(data){
		          if(data.result = 1){
		            notify('El dato fue eliminado correctamente.');
		            setTimeout(function(){
		              window.location.href = '<?= G_SERVER ?>/rb-admin/module.php?pag=forms';
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
				<div class="seccion-body">
				<table class="tables" border="0" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
							<th>Nombre</th>
							<th>Validaciones</th>
							<th>Shortcode</th>
						</tr>
					</thead>
					<tbody>
						<?php include('forms.list.php') ?>
					</tbody>
				</table>
				</div>
			</section>
		</div>
		<?php
		endif;
	}
	// Agregar al sistema
	add_function('module_content_main','forms_editor');

endif;

function show_form( $params ){ // Mostrar el formulario segun su id
	global $objDataBase;
	$r = $objDataBase->Ejecutar('SELECT * FROM forms WHERE id='.$params['id']);
	$form = $r->fetch_assoc();

	$formhtml = "
	<script>
	$(document).ready(function() {
		$('#".$form['name_id']."').submit(function (){
			event.preventDefault();
			$.ajax({
				method: 'post',
				url: '".G_SERVER."/rb-script/modules/rb-mailer/mailer.form.db.php',
				data: $( this ).serialize()
			})
			.done(function( data ) {
				if(data.result){
					console.log(data);
					$('#".$form['name_id']."').slideUp();
					$('#frmresponse_".$form['id']."').html('<p style=\"color:green\">'+data.msg+'</p>');
				}else{
					console.log(data);
					$('#frmresponse_".$form['id']."').html('<p style=\"color:red\">'+data.msg+'</p>');
				}
			});
		});
	});
	</script>";
	$formhtml .= "<form class='form' id='".$form['name_id']."'>";
	$formhtml .= "<input type='hidden' name='form_id' value='".$form['id']."' />";
	$formhtml .= html_entity_decode($form['estructure']);
	$formhtml .= "</form>";
	$formhtml .= "<div id='frmresponse_".$form['id']."'></div>";
	return $formhtml;
}

function test(){
	return "Esto es una demostración de como usar los shortcodes - primitivo";
}

/*
* Hay que crear los shortcodes para cada formulario, ANTES de usarse en el sistema,
* NO DURANTE, pues no es posible cuando se trata de funciones dinamicas.
*/
$r = $objDataBase->Ejecutar('SELECT * FROM forms');
while($form = $r->fetch_assoc()){
	add_shortcode('FORM', 'show_form', ['id' => $form['id'] ]);
}
add_shortcode('DEMO', 'test');
/*add_shortcode('FORM', 'show_form', ['id' => 7 ]);
add_shortcode('FORM', 'show_form', ['id' => 6 ]);*/
?>
