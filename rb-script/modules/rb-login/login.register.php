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
				<div class="frmlogin" id="msj-final" class="msg success" style="display:none;"></div>

				<form id="frmRegister" class="frmlogin" action="<?= $rm_url ?>rb-script/modules/rb-login/user.register.php" method="post" name="login">
					<div class="cover-imagen-login" style="background:url('<?= rb_photo_login(G_LOGO) ?>') no-repeat center center;background-size:cover;"></div>
					<h2>Cuenta nueva</h2>
					<?php if(isset($msg)): ?><p style="text-align: center"> <?= $msg?></p> <?php endif; ?>
					<div id="msj-frm" style="display: none" class="info"></div>

					<input type="hidden" name="response" value="ajax" />
					<input type="text" name="usuario" required placeholder="E-mail" />
					<input type="password" name="contrasena1" required placeholder="Password" />
					<input type="password" name="contrasena2" required placeholder="Repite Password" />
					<label>
						<input type="checkbox" name="terminos"> <a href="<?= rb_url_link('pag','terminos-y-condiciones') ?>">Términos y condiciones de registro</a>
					</label>
					<div class="submit">
						<button name="login">Registrar</button>
					</div>
					<p>
						<a href="<?= $rm_url ?>login.php?recovery">Recuperar mi cuenta</a> <a href="<?= $rm_url ?>login.php">Iniciar Sesión</a>
					</p>
				</form>
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
