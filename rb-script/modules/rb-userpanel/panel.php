<?php
$rm_menu = "cuenta";
$rm_title = "Panel Usuario - ".G_ESTILO;
$rm_slide = false;
require_once ABSPATH.'rb-temas/'.G_ESTILO.'/header.php';
?>
<?php
$q = $objArticulo->Consultar("select * from usuarios where id=".$rm_userid);
$UsuarioItem = mysql_fetch_array($q);
?>
		<div class="wrap-content">
			<div class="inner-content intrader-index-block-in in-page">
		<!--<div id="panel" class="contact">
			<div class="container">-->

				<div class="user">
					<h1>Mi cuenta <?= $UsuarioItem['activo']==0 ? "<span class='info-active'>Cuenta no activa: Revise su correo y active</span>" : "" ?></h1>
					<script type="text/javascript">
						$(document).ready(function() {
							$( "#history" ).click(function(event) {
								event.preventDefault();
								$( ".history, .works, .data" ).hide();
								$( "#history, #works, #data" ).removeClass( 'selected');
								$( ".history" ).show();
								$( this ).addClass( 'selected');
								$(window).resize();
							});
							$( "#works" ).click(function(event) {
								event.preventDefault();
								$( ".history, .works, .data" ).hide();
								$( "#history, #works, #data" ).removeClass( 'selected');
								$( ".works" ).show();
								$( this ).addClass( 'selected');
								$(window).resize();
							});
							$( "#data" ).click(function(event) {
								event.preventDefault();
								$( ".history, .works, .data" ).hide();
								$( "#history, #works, #data" ).removeClass( 'selected');
								$( ".data" ).show();
								$( this ).addClass( 'selected');
								$(window).resize();
							});
						});
					</script>
					<div class="cols-container">
						<div class="cols-2-sm buttons" style="padding: 0">
							<ul class="menu-user">
								<li>
									<a href="#" id="data" class="selected">Mis datos</a>
								</li>
								<li>
									<a href="#" id="history">Notificaciones</a>
								</li>
							</ul>
						</div>
						<div class="cols-10-sm" style="border-left:1px solid #eaeaea">
							<div class="history">
								<h3>Notificaciones</h3>
								<?php require 'panel.notifications.php' ?>
							</div>
							<?php
							function show_nivel($nivel_id){
								$objUsuario = new Usuarios;
								$q = $objUsuario->Consultar("SELECT nombre FROM usuarios_niveles WHERE id=$nivel_id");
								$r = mysql_fetch_array($q);
								return $r['nombre'];
							}
							?>
							<div class="data">
								<h3>Datos del usuario</h3>
								<p>Nivel: <?= show_nivel($UsuarioItem['tipo']) ?></p>
								<?php if(G_USERTYPE=="admin" || G_USERTYPE=="user-panel"): ?>
								<p><a href="<?= $rm_url ?>rb-admin/">Administrar contenidos</a></p>
								<?php endif ?>
								<?php require 'panel.user.php' ?>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
<?php require_once ABSPATH.'rb-temas/'.G_ESTILO.'/footer.php' ?>
