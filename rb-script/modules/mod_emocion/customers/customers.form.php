<?php
// 24-06-17: Jiustus
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/');

require_once(ABSPATH.'global.php');

if(isset($_GET['uid'])):
	require_once(ABSPATH."rb-script/class/rb-database.class.php");
	$mode = "upd";
	$q = $objDataBase->Ejecutar("SELECT * FROM emo_customers WHERE id='".trim($_GET['uid']."'"));
  $customer = mysql_fetch_array($q);
else:
	$mode = "new";
endif;
?>
<div id="message_general"></div>
<form id="emo_formup" class="emo_formup" method="post" action="sendfile_mailer.php" style="width:500px">
	<input type="hidden" name="mode" value="<?= $mode ?>" />
	<input type="hidden" name="id" value="<?php if(isset($customer)) echo $customer['id'] ?>" />
	<label>
		<span>Codigo *</span>
		<input id="codigo" name="codigo" type="text" data-required="required" value="<?php if(isset($customer)) echo $customer['codigo'] ?>" />
	</label>
	<label>
		<span>Nombre de la empresa *</span>
		<input id="empresa" name="empresa" type="text" data-required="required" value="<?php if(isset($customer)) echo $customer['empresa'] ?>" />
	</label>
	<label>
		<span>RUC</span>
		<input id="empresa_ruc" name="empresa_ruc" type="text" value="<?php if(isset($customer)) echo $customer['empresa_ruc'] ?>" />
	</label>
	<label>
		<span>Dirección</span>
		<input id="empresa_direccion" name="empresa_direccion" type="text" value="<?php if(isset($customer)) echo $customer['empresa_direccion'] ?>" />
	</label>
	<label>
		<span>Nombres y apellidos del contacto *</span>
    <input id="contacto_nombres" type="text" name="contacto_nombres" data-required="required" value="<?php if(isset($customer)) echo $customer['contacto_nombres'] ?>" />
  </label>
  <label>
		<span>Correo contacto *</span>
		<input id="contacto_correo" type="email" name="contacto_correo" data-required="required" value="<?php if(isset($customer)) echo $customer['contacto_correo'] ?>" />
	</label>
	<label>
		<span>Telefono contacto</span>
		<input id="contacto_telefono" type="tel" name="contacto_telefono" value="<?php if(isset($customer)) echo $customer['contacto_telefono'] ?>" />
	</label>
	<label>
		<span>Celular del contacto</span>
		<input id="contacto_celular" type="tel" name="contacto_celular" value="<?php if(isset($customer)) echo $customer['contacto_celular'] ?>" />
	</label>
	<label id="links">
		<span>Páginas web</span>
		<?php
		if(isset($customer)):
			if(strlen($customer['empresa_webs'])>0):
				$arr = json_decode($customer['empresa_webs']);
				$i=1;
				foreach ($arr as $key => $value) {
				?>
				<div class="link cols-container">
					<div class="cols-11-md">
						<input type="text" name="empresa_webs[]" placeholder="Pagina Web" data-required="required" value="<?= $value ?>" />
					</div>
					<div class="cols-1-md">
						<?php if($i>1): ?>
						<a title="Quitar" class="linkdelete" href="#"><img height="12" width="12" src="<?= G_SERVER ?>/rb-script/modules/mod_emocion/img/delete.png" alt="Borrar" /></a>
						<?php endif ?>
					</div>
				</div>
				<?php
				$i++;
				}
			endif;
		else: ?>
			<div class="link cols-container">
				<div class="cols-11-md">
					<input type="text" name="empresa_webs[]" placeholder="Pagina Web" data-required="required" />
				</div>
				<div class="cols-1-md"></div>
			</div>
		<?php
		endif ?>
	</label>
	<span class="more">
		<a id="new_link" href="#">Añadir web</a>
	</span>
	<p style="text-align: right">Los campos con asteriscos (*) son obligatorios</p>
	<div style="text-align: right">
		<?php
		if(isset($customer)):
			?>
			<button id="btnSend" type="submit">Actualizar</button>
			<?php
		else:
			?>
			<button id="btnSend" type="submit">Crear</button>
			<?php
		endif ?>
	</div>
</form>

<script type="text/javascript">
$(document).ready(function(){
	/* P A R A   L I N K S */
  $( "#new_link" ).click(function(event) {
    event.preventDefault();
    $('#links .link:last').after(
    '<div class="link cols-container">'+
      '<div class="cols-11-md">'+
        '<input type="text" name="empresa_webs[]" placeholder="Pagina Web"  data-required="required" />'+
      '</div>'+
      '<div class="cols-1-md">'+
      '<a title="Quitar" class="linkdelete" href="#"><img height="12" width="12" src="<?= G_SERVER ?>/rb-script/modules/mod_emocion/img/delete.png" alt="Borrar" /></a>'+
      '</div>'+
    '</div>');
    $('.link input').focus();
  });
	$('#links').on("click", ".linkdelete", function (event) {
		event.preventDefault();
	  $(this).closest(".link").remove();
	  $('.link input').focus();
	});
	// VALIDACION CON JQUERY EXPERIMENTAL - data-required="required"
	var validateInputs = function(form){
		var continuee = true;
		$("form"+form+" input").each(function(){
			var input_type = $(this).attr('type');
 			var input_required = $(this).attr('data-required');
			if(input_required=="required"){
				if($(this).val()==""){
					$(this).addClass('input_red');
					$(this).focus();
					$(this).nextAll().remove();
					$(this).after('<span style="color:red;font-size:.8em;">Este campo no puede estar vacio.</span>');
					continuee = false;
				}else{
					$(this).removeClass('input_red');
					$(this).nextAll().remove();
				}
			}
			var input_id = $(this).attr('id');
		});
		return continuee;
	}
	// E N V I A N D O  D A T O S
	$('#emo_formup').submit(function(event){
		event.preventDefault();
		console.log(validateInputs('#emo_formup'));
		if(validateInputs('#emo_formup')===false) return false;

		$.ajax({
			url: "<?= G_SERVER ?>/rb-script/modules/mod_emocion/customers/customers.save.php",
			data: $( this ).serialize(),
			method: 'post'
		}).done(function(data) {
			console.log(data);
			if(data=="1"){
				$('.emo_formup').hide();
				$('#message_general').html("<div style='text-align:center;padding:10px 0'><img src='<?= G_SERVER ?>/rb-script/modules/rb-uploadimg2/send.png' alt='send'></div><h3 style='text-align:center;padding:8px 0'>Cliente nuevo creado. Espere ...</h3>")
				setTimeout(function(){
					window.location.href = '<?= G_SERVER ?>/rb-admin/module.php?pag=emo_clientes';
				}, 1500);
			}else{
				$('#message_general').html(data);
			}
		});
	});
});
</script>
