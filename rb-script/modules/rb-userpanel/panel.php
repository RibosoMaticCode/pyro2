<?php
$rm_menu = "cuenta";
$rm_slide = false;
rb_header(['header-allpages.php'], false);
$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."users WHERE id=".G_USERID);
$UsuarioItem = $q->fetch_assoc();

if(isset($_GET['section'])){
  $sec = $_GET['section'];
}else{
  $sec = "data"; // default
}
?>
<div class="winfloat" style="display: none"></div>
<div class="wrap-content">
	<div class="inner-content">
		<div class="user">
			<h1>Mi cuenta <?= $UsuarioItem['activo']==0 ? "<span class='info-active'>Cuenta no activa: Revise su correo y active</span>" : "" ?></h1>
			<script type="text/javascript">
				$(document).ready(function() {
          $( ".panels_user .panel" ).hide(); // ocultamos todos los paneles
          $(".<?= $sec ?>_panel").show();

					$(".menu_user_item").click(function(event){
						event.preventDefault();
						var panel = $(this).attr('data-panel');

						$( ".panels_user .panel" ).hide();
						$("."+panel).show();
						$( ".menu-user a" ).removeClass( 'selected');
						$(this).addClass( 'selected');
					});
				});
			</script>
			<div class="cols-container">
				<div class="cols-2-md buttons">
					<ul class="menu-user">
            <?php

            ?>
						<!--<li>
							<a href="#" id="data" class="menu_user_item selected" data-panel="panel_datauser">Mis datos</a>
						</li>
						<li>
							<a href="#" id="history" class="menu_user_item" data-panel="panel_notifications">Notificaciones</a>
						</li>-->
            <?php
						foreach ($menu_user_panel as $menu => $submenus) { // revisando los array de nivel superior
							foreach ($submenus as $submenu){  // revisar los items hijos que tiene el array superior
								?>
								<li>
									<a href="#" id="<?= $submenu['key'] ?>" class="menu_user_item <?php if($sec==$submenu['key']) echo "selected" ?>" data-panel="<?= $submenu['key'] ?>_panel"><?= $submenu['title'] ?></a>
								</li>
								<?php
							}
						}
						?>
					</ul>
				</div>
				<div class="cols-10-md">
					<div class="panels_user">
						<?php include_once 'panel.user.php' ?>
						<?php include_once 'panel.notifications.php' ?>
						<?= do_action('panel_user_section') ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
