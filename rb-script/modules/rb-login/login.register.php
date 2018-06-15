<?php
if(G_ACCESOUSUARIO==1):
	header('Location: index.php');
else:
	if(G_LINKREGISTER==1 || G_LINKREGISTER==2):
		$page_title = "Registrarse";
		require_once 'login.header.php'
		?>
		<script src="<?= G_SERVER ?>/rb-script/modules/rb-login/login.js?url=<?= G_SERVER ?>"></script>
		<div class="bg"></div>
		<div id="msj-frm" style="display: none" class="info"></div>
		<div class="wrap-content">
			<div class="content">
						<?php if (isset($_COOKIE['_register2'])):?>
							<div class="frmlogin frmlogin-abs" id="msg-ok" class="msg success">
								<p>El registro se completo con éxito!</p>
								<p>Nuestro sistema no puede registrar una cuenta por ahora. Intentalo luego.</p>
								<p>Saludos.</p>
								<p>Volver a la <a href="<?= $rm_url ?>">web</a></p>
							</div>
						<?php else: ?>
						<!--<div class="frmlogin frmlogin-abs" id="msj-final" class="msg success" style="display:none;"></div>-->
						<form autocomplete="off" id="frmRegister" class="frmlogin frmlogin-abs" action="<?= $rm_url ?>rb-script/modules/rb-login/user.register.php" method="post" name="login">
							<div class="cover-imagen-login" style="background:url('<?= rb_photo_login(G_LOGO) ?>') no-repeat center center;background-size:cover;"></div>
							<h2>Cuenta nueva</h2>
							<?php if(isset($msg)): ?><p style="text-align: center"> <?= $msg?></p> <?php endif; ?>
							<input type="hidden" name="response" value="ajax" />
							<input type="text" name="nombres" required placeholder="Nombres" autocomplete="off" />
							<div class="tooltip">
								<input type="text" name="usuario" class="pass" id="nickname" required placeholder="Correo electrónico" autocomplete="off" />
								<span class="tooltiptext">Ingrese un correo electrónico valido, le enviaremos información para que active su cuenta.</span>
								<span id="nickname_notify" class="notify"></span>
							</div>
							<div class="tooltip">
								<input type="password" name="contrasena1" class="pass" id="pass1" required placeholder="Contraseña" autocomplete="off" />
								<span class="tooltiptext">La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos.</span>
								<span id="pass1_notify" class="notify"></span>
							</div>
							<div class="tooltip">
								<input type="password" name="contrasena2" class="pass" id="pass2" required placeholder="Repite la contraseña" autocomplete="off" />
								<span class="tooltiptext">La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos.</span>
								<span id="pass2_notify" class="notify"></span>
							</div>
							<label>
								<input type="checkbox" id="terms_check" name="terminos"> Ver términos y condiciones de registro del sitio
							</label>
							<div class="submit">
								<button name="login" class="btnRegister" disabled>Registrar</button>
							</div>
							<p>
								<a href="<?= $rm_url ?>login.php?recovery">Recuperar mi cuenta</a> <a href="<?= $rm_url ?>login.php">Iniciar Sesión</a>
							</p>
						</form>
						<div id="terms" class="terms">
							<iframe src="<?= rb_get_values_options('terms_url') ?>"></iframe>
							<a id="terms_confirm" class="btnConfirm" href="#">Acepto los terminos y condiciones que estable este sitio web</a>
							<a href="#" class="btnCancel">Cancelar</a>
						</div>
						<?php endif; ?>
						<!--<?php if(G_ESTILO!="0"): ?>
							<a class="link-back" href="<?= $rm_url ?>">Volver a la web</a>
						<?php endif ?>-->
					</div>
				</div>
			<?php require_once 'login.footer.php' ?>
		<?php
	else:
		header('Location: '.$rm_url.'login.php');
	endif;
endif;
?>
