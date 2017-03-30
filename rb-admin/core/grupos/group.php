<?php
// Valores iniciales
$rb_module_title = "Grupos";
$rb_module_title_section = "Grupos";
$rb_module_path = "Inicio > Grupos";
$rb_module_url_main = G_SERVER."/rb-admin/index.php";
$rb_module_url = G_SERVER."/rb-admin/core/grupos/";
$rb_module_url_img = "";

// Menu
rb_add_specific_item_menu('users', array(
			'key' => 'gru',
			'nombre' => "Grupos",
			'url' => "module.php?pag=gru",
			'url_imagen' => "none",
			'pos' => 1
	));

if(isset($_GET['pag']) && $_GET['pag']=="gru"):
	if($userType != "admin"):
		printf(" No tiene permiso de Administrador ");
		break;
	endif;
	// Contenido inicial
	function group_admin_content(){
		if(isset($_GET['opc'])):
			$opc=$_GET['opc'];
			include('group.edit.php');
		else:
		?>
		<div id="sidebar-left">
			<ul class="buttons-edition">
				<li><a class="btn-primary" href="../rb-admin/modules.php?pag=gru&amp;opc=nvo"><img src="img/add-white-16.png" alt="Nuevo"> Nuevo</a></li>
				<li><a class="btn-primary" href="#" id="edit"><img src="img/edit-white-16.png" alt="Editar"> Editar</a></li>
				<li><a class="btn-primary" href="#" id="delete"><img src="img/del-white-16.png" alt="delete"> Eliminar</a></li>
			</ul>
		</div>
		<div class="wrap-content-list">
			<section class="seccion">
				<table class="tables" border="0" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
							<th>Grupo</th>
						</tr>
					</thead>
					<tbody>
						<?php include('group.list.php') ?>
					</tbody>
				</table>
			</section>
		</div>
	<?php
		endif;
	}

	add_function('module_content_main','group_admin_content');
endif;
//$sec="nivel";
?>
