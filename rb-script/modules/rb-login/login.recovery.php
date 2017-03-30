<?php
if(G_ACCESOUSUARIO==1):
	header('Location: index.php');
else:
	$page_title = "Recuperar contraseña";
	require_once 'login.header.php'
?>
		<div class="wrap-content">
			<div class="content">
				<?php
				if(isset($msg)){
					echo $msg;
				}
				?>
				<form class="frmlogin" action="login.php" name="login" method="post">
					<div class="cover-imagen-login" style="background:url('<?= rb_photo_login(G_LOGO) ?>') no-repeat center center;background-size:cover;"></div>
					<h2>Recupera tu contraseña</h2>
					<input type="text" name="mail" placeholder="Escribe tu correo electronico" required />

					<div class="submit">
						<button name="recovery">Enviar</button>
					</div>
					<p>
						Volver a <a href="<?= $rm_url ?>login.php">Iniciar Sesión</a>
					</p>
				</form>
				<a class="link-back" href="<?= $rm_url ?>">Volver a la web</a>
			</div>
		</div>
	</body>
	</html>
<?php
endif;
?>
