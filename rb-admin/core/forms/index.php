<?php
// Añadir modulo al menu
rb_add_specific_item_menu('visual', array(
			'key' => 'forms',
			'nombre' => "Formularios",
			'url' => "forms"
));

// Formulario nuevo
$url = rb_module_url('forms/new');
if( $url['result'] ):
	function forms_title_new(){
		return "Nuevo formulario";
	}
	add_function('module_title_page', 'forms_title_new' );

	function form_editor_new(){
		include('forms.edit.php');
	}
	add_function('module_content_main','form_editor_new');
endif;

// Formulario edit
$url = rb_module_url('forms/edit/<item>');
if( $url['result'] ):
	$item = $url['parameters']['item'];
	function forms_title_edit(){
		return "Editar formulario";
	}
	add_function('module_title_page', 'forms_title_edit' );

	function form_editor_edit(){
		global $item, $objDataBase;
		include('forms.edit.php');
	}
	add_function('module_content_main','form_editor_edit');
endif;

// Relacion de formularios
$url = rb_module_url('forms');
if( $url['result'] ):
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

	// Mostrar lista
	function forms_list(){
		global $objDataBase;
		include('forms.php');
	}
	// Agregar al sistema
	add_function('module_content_main','forms_list');
endif;

function show_form( $params ){ // Mostrar el formulario segun su id
	global $objDataBase;
	$r = $objDataBase->Ejecutar('SELECT * FROM '.G_PREFIX.'forms WHERE id='.$params['id']);
	$form = $r->fetch_assoc();

	$formhtml = "
	<script>
	$(document).ready(function() {
		$('#".$form['name_id']."').submit(function (event){
			event.preventDefault();
			$.ajax({
				method: 'post',
				url: '".G_SERVER."rb-script/modules/rb-mailer/mailer.form.db.php',
				data: $( this ).serialize()
			})
			.done(function( data ) {
				if(data.result){
					console.log(data);
					$('#".$form['name_id']."').slideUp();
					//$('#frmresponse_".$form['id']."').html('<p style=\"color:green\">'+data.msg+'</p>');
					$('#frmresponse_".$form['id']."').html(data.msgHtml);
				}else{
					console.log(data);
					$('#frmresponse_".$form['id']."').html('<p style=\"color:red\">'+data.msg+'</p>');
				}
			});
		});
	});
	</script>";
	$formhtml .= "<div class='frm_intro'>".$form['intro']."</div>";
	$formhtml .= "<form class='form' id='".$form['name_id']."'>";
	$formhtml .= "<input type='hidden' name='form_id' value='".$form['id']."' />";
	$formhtml .= html_entity_decode($form['estructure']);
	$formhtml .= "</form>";
	$formhtml .= "<div class='frm_response' id='frmresponse_".$form['id']."'></div>";
	return $formhtml;
}
/*
* Hay que crear los shortcodes para cada formulario, ANTES de usarse en el sistema,
* NO DURANTE, pues no es posible cuando se trata de funciones dinamicas.
*/
$r = $objDataBase->Ejecutar('SELECT * FROM '.G_PREFIX.'forms');
while($form = $r->fetch_assoc()){
	add_shortcode('FORM', 'show_form', ['id' => $form['id'] ]);
}
/*add_shortcode('FORM', 'show_form', ['id' => 7 ]);
add_shortcode('FORM', 'show_form', ['id' => 6 ]);*/

function test(){
	return "Esto es una demostración de como usar los shortcodes - primitivo";
}
add_shortcode('DEMO', 'test');
?>
