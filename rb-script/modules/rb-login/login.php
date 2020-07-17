<?php
if(G_ACCESOUSUARIO==1):
	header('Location: index.php');
else:
	$page_title = "Iniciar sesión";
	require_once 'login.header.php';
	if(isset($_GET['msg'])){
		switch($_GET['msg']){
			case "1":
				$msg = "Los campos no fueron llenados";
				break;
			case "2":
				$msg = "El usuario no existe";
				break;
			case "3":
				$msg = "El usuario no esta activado aún";
				break;
			case "4":
				$msg = "El usuario y contraseña no coinciden";
				break;
			case "5":
				$msg = "Conectado";
				break;
			case "6":
				$msg = "Cuenta activa, puedes iniciar sesión";
				break;
		}
	}
?>
<script>
$(document).ready(function() {
	$(".bg, #msj-frm").show().delay(3000).fadeOut();
});
</script>
<?php if(isset($msg)): ?>
	<div class="bg" style="display:block"></div>
	<div id="msj-frm"> <?= $msg?></div>
<?php endif; ?>
		<div class="wrap-content">
			<div class="content">
					<form class="frmlogin frmlogin-abs" action="<?= $rm_url ?>login.php" method="post" name="login">
						<div class="cover-imagen-login" style="background:url('<?= rb_photo_login(G_LOGO) ?>') no-repeat center center;background-size:cover;"></div>
						<h2>Acceso</h2>
						<?php
						if(isset($_GET['redirect'])) $url_redirect = $_GET['redirect'];
						else $url_redirect = "";
						?>
						<input type="hidden" name="redirect" value="<?= $url_redirect ?>" />
						<input type="text" name="usuario" required placeholder="Correo, nombre de usuario o teléfono" autocomplete="off" />
						<input type="password" name="contrasena" required placeholder="Contraseña" autocomplete="off" />
						<div class="cols-container">
							<label class="cols-6-md center">
							<input type="checkbox" name="remember" <?php if(isset($_COOKIE["login_remember"])) echo ' value="1" checked '; else echo ' value="0"';?>>
								<span>Recordar mis datos</span>
							</label>
							<a class="cols-6-md center" href="<?= $rm_url ?>login.php?recovery">Olvide mi password</a>
						</div>
						<div class="submit">
							<button name="login">Ingresar</button>
						</div>
						<?php if(G_LINKREGISTER==1): ?>
						<p>
							¿No estas registrado? <a href="<?= $rm_url ?>login.php?reg">Crea una cuenta</a>
						</p>
						<?php endif; ?>
					</form>
					<!--<?php if(G_ESTILO!="0"): ?>
						<a class="link-back" href="<?= $rm_url ?>">Volver a la web</a>
					<?php endif ?>-->
			</div>
		</div>
	<?php require_once 'login.footer.php' ?>
<?php
endif;
?>
