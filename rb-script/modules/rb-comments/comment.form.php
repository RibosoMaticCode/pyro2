<?php
//************** con base de datos*****************
if(isset($_GET['art_id']) && !empty($_GET['art_id'])){
	$art_id = $_GET['art_id'];
	
	if(isset($_GET['cantidad']) && !empty($_GET['cantidad'])){
		$cantidad = $_GET['cantidad'];
	}else{
		$cantidad = 1;
	}
}else{
	die("Algo anda mal :S, recargue la página");
}

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH.'rb-script/class/rb-articulos.class.php');
require_once(ABSPATH.'rb-script/class/rb-usuarios.class.php');

if(G_ACCESOUSUARIO==1):
	$rm_userid = G_USERID;
	$res_u = $objUsuario->Consultar("SELECT * FROM usuarios WHERE id=".$rm_userid);
	$row_u = mysql_fetch_array($res_u);
	$rm_usermail = $row_u['correo'];
	$rm_usernames = $row_u['nombres'];
else:
	$rm_userid = 0;
	$rm_usernames = "";
	$rm_usermail = "";
endif;

$q = $objArticulo->Consultar("SELECT * FROM articulos WHERE id=".$art_id);
$art = mysql_fetch_array($q);
?>
				<script>
					$(document).ready(function() {
						$('#frmCotizarSender').submit( function(){
							event.preventDefault();
							
							$.ajax({
  								url: "<?= G_SERVER ?>/rb-script/modules/rb-comments/comment.save.php",
  								method: 'POST',
  								dataType: "json",
  								data: $( this ).serialize()
							})
  							.done(function( data ) {
  								if(data.resultado=="ok"){
  									$( "#resenas-list" ).append(data.contenido);
  									$("#bg").fadeOut();
									$(".winfloat").hide();
  								}else{
  									$( "#PedidoResult" ).html("Ocurrio un problema! Intentelo más tarde");
  								}
  							});
						})
					})
				</script>
		<div id="PedidoResult">
		<form class="frmpopup" method="post" action="<?= G_SERVER ?>/rb-temas/<?= G_ESTILO ?>/comentario.save.php" id="frmCotizarSender">
			<input type="hidden" name="articulo_id" value="<?= $art['id'] ?>" />
			<label>
				<span class="label">Nombres<span class="required">*</span></span>
				<div class="input"><input type="text" name="nombres" required value="<?= $rm_usernames ?>" <?php if(G_ACCESOUSUARIO==1) echo "readonly" ?> /></div>
				<input type="hidden" name="usuario_id" value="<?= $rm_userid ?>" />
			</label>
			<label>
				<span class="label">Correo Electronico <span class="required">*</span></span>
				<div class="input"><input type="email" name="email" required value="<?= $rm_usermail ?>" <?php if(G_ACCESOUSUARIO==1) echo "readonly" ?> /></div>
			</label>
			<label>
				<span class="label">Detalles <span class="required">*</span></span>
				<div class="input"><textarea rows="6" name="detalles" required></textarea></div>
			</label>
			<input type="hidden" name="url" value="" />	
			<div class="submit">
				<input type="submit" value="Enviar mi opinión" />
			</div>
		</form>
		</div>