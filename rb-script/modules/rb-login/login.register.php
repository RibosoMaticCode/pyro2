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
		<div class="frmlogin frmlogin-abs" id="msj-final" class="msg success" style="display:none;"></div>
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
						<form autocomplete="off" id="frmRegister" class="frmlogin frmlogin-abs" action="<?= $rm_url ?>rb-script/modules/rb-login/user.register.php" method="post" name="login">
							<div class="cover-imagen-login" style="background:url('<?= rb_photo_login(G_LOGO) ?>') no-repeat center center;background-size:cover;"></div>
							<h2>Cuenta nueva</h2>
							<?php if(isset($msg)): ?><p style="text-align: center"> <?= $msg?></p> <?php endif; ?>
							<input type="hidden" name="response" value="ajax" />
							<?php
							$fields = rb_get_values_options('more_fields_register');
							$array_fields = json_decode($fields, true);
							foreach ($array_fields as $key => $value) {
								?>
								<input type="text" name="<?= $key ?>" required placeholder="<?= $value ?>" autocomplete="off" />
								<?php
							}
							?>
							<div class="tooltip">
								<input type="text" name="usuario" class="pass" id="nickname" required placeholder="Correo electrónico" autocomplete="off" />
								<span class="tooltiptext">Ingrese un correo electrónico valido, le enviaremos información para que active su cuenta.</span>
								<span id="nickname_notify" class="notify"></span>
							</div>
							<?php
							$pass_security = rb_get_values_options('pass_security');
							if( $pass_security == 1 ):
								$msg_pass = "La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos.";
							else:
								$msg_pass = "Escriba una contraseña segura que conste de numeros, letras mayúsculas y minúsculas combinadas";
							endif;
							?>
							<div class="tooltip">
								<input type="password" name="contrasena1" class="pass" id="pass1" required placeholder="Contraseña" autocomplete="off" />
								<span class="tooltiptext"><?= $msg_pass ?></span>
								<span id="pass1_notify" class="notify"></span>
							</div>
							<?php
							$repit_pass_register = rb_get_values_options('repit_pass_register');
							if( $repit_pass_register == 1 ):
								?>
								<div class="tooltip">
									<input type="password" name="contrasena2" class="pass" id="pass2" required placeholder="Repite la contraseña" autocomplete="off" />
									<span class="tooltiptext"><?= $msg_pass ?></span>
									<span id="pass2_notify" class="notify"></span>
								</div>
							<?php
							endif;
							$show_terms_register = rb_get_values_options('pass_security');
							if( $show_terms_register == 1 ): ?>
							<label>
								<input type="checkbox" id="terms_check" name="terminos"> Ver términos y condiciones de registro del sitio
							</label>
							<?php endif ?>
							<div class="submit">
								<button name="login" class="btnRegister" <?php if( $show_terms_register == 1 ): ?> disabled <?php endif ?>>Registrar</button>
							</div>
							<p>
								<a href="<?= $rm_url ?>login.php?recovery">Recuperar mi cuenta</a> <a href="<?= $rm_url ?>login.php">Iniciar Sesión</a>
							</p>
						</form>
							<?php if( $show_terms_register == 1 ): ?>
							<div id="terms" class="terms">
								<iframe src="<?= rb_get_values_options('terms_url') ?>"></iframe>
								<a id="terms_confirm" class="btnConfirm" href="#">Acepto los terminos y condiciones que estable este sitio web</a>
								<a href="#" class="btnCancel">Cancelar</a>
							</div>
							<?php endif ?>
						<?php endif ?>
					</div>
				</div>
			<?php require_once 'login.footer.php' ?>
		<?php
	else:
		header('Location: '.$rm_url.'login.php');
	endif;
endif;
?>
