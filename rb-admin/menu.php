<?php
include 'islogged.php';
?>
<script>
$(document).ready(function() {
	$(".menu-item").click( function( event ){
		// Toda otra las lista mostrada la ocultamos
		$(".menu-item").next(".hidden").slideUp();
		// Removemos la clase de color de fondo
		$(".menu-item").closest("li").removeClass('bg-item-color');
		// Si la lista de items es visible
		if( $(this).next(".hidden").is(':visible') ){
			// Ocultamos y removemos la clase de color de fondo
			$(this).next(".hidden").slideUp();
			$(this).closest("li").removeClass('bg-item-color');
		}else{
			// Sino es visible
			// La lista lo hacemos visible y le agregamos el color de fondo
			$(this).next(".hidden").slideDown();
			$(this).closest("li").addClass('bg-item-color');
		}
	});
});
</script>
<?php
if(isset($_GET['pag'])){
	$seccion = $_GET['pag'];
}elseif(!isset($seccion)){
	$seccion = "index";
}
// Buscar item padre en el menu para pintarlo de color
$item_parent_selected = rb_action_menu($menu_panel, $seccion );
?>
<div id="bar_style" class="items">
<ul id="menu">
	<li class="item-user">
		<div class="cover-prof-img" style="background:url('<?= rb_get_img_profile( G_USERID ) ?>'); background-position:center; background-size: cover;"></div>
		<span style="font-size:1.1em;font-weight: bold;padding:5px 0;display: block">
			<a href="index.php?pag=usu&opc=edt&id=<?= G_USERID ?>&profile"><?= $root['nombres']?> <?= $root['apellidos']?></a>
		</span>
		<span style="font-size:.8em;padding:5px 0;display: block">
			Nivel <?= rb_shownivelname(G_USERNIVELID) ?>
		</span>
	</li>
	<?= rb_show_menu( $menu_panel , $seccion, $item_parent_selected ) ?>
	<li class="Cover_additem">
		<a class="additem" href="<?= G_SERVER ?>rb-admin/index.php?pag=opc">Configurar sitio</a>
	</li>
	<li class="Cover_additem">
		<a class="additem" href="<?= G_SERVER ?>rb-admin/modules.php">Modulos</a>
	</li>
	<li class="Cover_additem">
		<a class="additem" href="<?= G_SERVER ?>">Ir al sitio web</a>
	</li>
</ul>
<span class="CoverBtnMenuClose">
	<a class="btnMenuClose" href="#">
		<img src="<?= G_SERVER ?>rb-admin/img/close-menu.png" alt="close" />
	</a>
</span>
</div>
