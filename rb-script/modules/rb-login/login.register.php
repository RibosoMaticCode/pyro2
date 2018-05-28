<?php
if(G_ACCESOUSUARIO==1):
	header('Location: index.php');
else:
	if(G_LINKREGISTER==1):
		$page_title = "Registrarse";
		require_once 'login.header.php'
		?>
		<div class="wrap-content">
			<div class="content">
				<script type="text/javascript">
				$(document).ready(function() {
					// pass 1
					$("#pass1").keyup(function() {
						var url = "<?= $rm_url ?>rb-script/modules/rb-login/validate.pass.php";
						var text = $(this).val();
						//if(text.length>8){
							$.ajax({
					    	type: "GET",
					    	url: url,
					    	data: "pass="+text,
					    	success: function(data){
									console.log(data);
									if(data=="1"){
										$("#pass1").removeClass('pass_invalid').addClass('pass_valid');
									}else{
										$("#pass1").removeClass('pass_valid').addClass('pass_invalid');
									}
					    	}
							});
						//}
					});
					// pass 2
					$("#pass2").keyup(function() {
						var url = "<?= $rm_url ?>rb-script/modules/rb-login/validate.pass.php";
						var text = $(this).val();
						//if(text.length>8){
							$.ajax({
					    	type: "GET",
					    	url: url,
					    	data: "pass="+text,
					    	success: function(data){
									console.log(data);
									if(data=="1"){
										$("#pass2").removeClass('pass_invalid').addClass('pass_valid');
									}else{
										$("#pass2").removeClass('pass_valid').addClass('pass_invalid');
									}
					    	}
							});
						//}
					});

					$("#frmRegister").submit(function(e) {
						e.preventDefault();
						var url = "<?= $rm_url ?>rb-script/modules/rb-login/user.register.php";
					    $.ajax({
					    	type: "POST",
					    	url: url,
					    	data: $("#frmRegister").serialize(),
					    	dataType: 'json',
					    	success: function(data){
					    		if(data['codigo']==0){ // Codigo correcto!
					    			$('#frmRegister').slideUp();
					    			$("#msj-final").show();
					    			$("#msj-final").html(data['mensaje']);
					    		}else{
					    			$("#msj-frm").show().delay(4000).fadeOut();
					    			$("#msj-frm").html(data['mensaje']);
					    		}
					    	}
					    });
					});

					$('#terms_check').click(function(e){
						if ($('#terms_check').is(':checked')) {
							$('.bg').show();
							$('.terms').show();
						}else{
							$('.btnRegister').prop('disabled', true);
						}
					});
					$('.btnCancel').click(function(e){
						$('.bg').hide();
						$('.terms').hide();
						$('#terms_check').prop('checked', false);
					});
					$('#terms_confirm').click(function(e){
						$('.bg').hide();
						$('.terms').hide();
						$('.btnRegister').prop('disabled', false);
					});
				});
				</script>
						<?php if (isset($_COOKIE['_register2'])):?>
							<div class="frmlogin frmlogin-abs" id="msg-ok" class="msg success">
								<p>El registro se completo con éxito!</p>
								<p>Nuestro sistema no puede registrar una cuenta por ahora. Intentalo luego.</p>
								<p>Saludos.</p>
								<p>Volver a la <a href="<?= $rm_url ?>">web</a></p>
							</div>
						<?php else: ?>
						<div class="frmlogin frmlogin-abs" id="msj-final" class="msg success" style="display:none;"></div>

						<form id="frmRegister" class="frmlogin frmlogin-abs" action="<?= $rm_url ?>rb-script/modules/rb-login/user.register.php" method="post" name="login">
							<div class="cover-imagen-login" style="background:url('<?= rb_photo_login(G_LOGO) ?>') no-repeat center center;background-size:cover;"></div>
							<h2>Cuenta nueva</h2>
							<?php if(isset($msg)): ?><p style="text-align: center"> <?= $msg?></p> <?php endif; ?>
							<div id="msj-frm" style="display: none" class="info"></div>

							<input type="hidden" name="response" value="ajax" />
							<input type="text" name="nombres" required placeholder="Nombres" />
							<input type="text" name="usuario" required placeholder="Correo electrónico" />

							<div class="tooltip">
								<input type="password" name="contrasena1" class="pass" id="pass1" required placeholder="Contraseña" />
								<span class="tooltiptext">La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos.</span>
							</div>
							<div class="tooltip">
								<input type="password" name="contrasena2" class="pass" id="pass2" required placeholder="Repite la contraseña" />
								<span class="tooltiptext">La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos.</span>
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
						<div class="bg"></div>
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
