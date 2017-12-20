<?php
if(G_ACCESOUSUARIO==1):
	header('Location: index.php');
else:
	$page_title = "Nueva contraseña";
	require_once 'login.header.php'
?>
		<div class="wrap-content">
			<div class="content">
				<?php
				if(isset($msg)){
					echo $msg;
				}
				?>
				<form class="frmlogin frmlogin-abs" action="login.php" name="login" method="post">
					<div class="cover-imagen-login" style="background:url('<?= rb_photo_login(G_LOGO) ?>') no-repeat center center;background-size:cover;"></div>
					<h2>Nueva contraseña</h2>
					<label>
						<span>Escriba su nueva contrase&ntilde;a:</span>
						<input type="password" name="pass1" required />
					</label>
					<label>
						<span>Repita la contrase&ntilde;a:</span>
						<input type="password" name="pass2" required />
					</label>
					<input type="hidden" name="mail" value="<?= $mail ?>" />

					<div class="submit">
						<button name="newpass">Enviar</button>
					</div>
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
