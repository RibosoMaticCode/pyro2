<?php
$mainmenu_id = $_GET['id'];
?>
<nav class="menu-edition">
	<ul id="subitems" class="main column">
	<?php rb_menus_edition($mainmenu_id,0,0); ?>
	</ul>
</nav>

<?php
function rb_menus_edition($mainmenu_id, $parent, $level) {
	global $objDataBase;

	$result = $objDataBase->Ejecutar("SELECT mi.nivel, mi.id, mi.mainmenu_id, mi.nombre, mi.url, mi.tipo, mi.style, mi.img, Items.Count FROM ".G_PREFIX."menus_items mi  LEFT OUTER JOIN (SELECT menu_id, COUNT(*) AS Count FROM ".G_PREFIX."menus_items GROUP BY menu_id) Items ON mi.id = Items.menu_id WHERE mi.menu_id=". $parent." AND mi.mainmenu_id=".$mainmenu_id. " ORDER BY id");
    while ($row = $result->fetch_assoc()):
    	$class_nivel = "margen_". $row['nivel'];
    	//$tipo = trim($row['tipo']);
			switch($row['tipo']) {
				case 'per':
					$type_det = "Personalizado";
				break;
				case 'pag':
					$type_det = "Pagina";
				break;
				/*case 'art':
					$type_det = "Publicacion de Blog";
				break;
				case 'cat':
					$type_det = "Categoria de Blog";
				break;*/
			}
        if ($row['Count'] > 0):
            ?>
            <li class="item" data-id="item<?= $row['id'] ?>" data-title="<?= $row['nombre'] ?>" data-url="<?= $row['url'] ?>" data-menumain="<?= $row['mainmenu_id'] ?>" data-type="<?= $row['tipo'] ?>" data-style="<?= $row['style'] ?>" data-img="<?= $row['img'] ?>">
            	<div class="header">
            		<span class="item-title"><?= html_entity_decode($row['nombre']) ?></span> [<?=$type_det ?>]
            	</div>
            	<a class="more" href="#"><span class="arrow-up" style="display: none;">&#9650;</span><span class="arrow-down">&#9660;</span></a>
            	<div class="item-body" style="display: none">
            		<label title="Titulo del Item" for="nombre">Titulo del Item:
            			<input id="item-menu-name-<?= $row['id'] ?>" autocomplete="off"  name="nombre" class="menu_title" type="text" value="<?= $row['nombre'] ?>" required />
            		</label>
            		<?php
            		if($row['tipo']=="per"):
            		?>
            			<label title="URL" for="nombre">URL (incluir http://):
            				<input id="item-menu-url-<?= $row['id'] ?>" autocomplete="off"  name="url" class="menu_url" type="text" value="<?= $row['url'] ?>" required />
            			</label>
            		<?php
								endif;
            		?>
								<label>URL de imagen:
            			<input id="item-menu-img-<?= $row['id'] ?>" autocomplete="off"  name="img" class="menu_img" type="text" value="<?= $row['img'] ?>" required />
            		</label>
            		<label>Clase CSS (Se aplica a los subitems):
            			<input id="item-menu-css-<?= $row['id'] ?>" name="estilo" class="menu_style" type="text" value="<?= $row['style'] ?>" />
            		</label>
            		<button class="button delete">Eliminar</button>
            	</div>
            	<ul class="column item sortable">
            		<?php rb_menus_edition($mainmenu_id, $row['id'], $level + 1) ?>
            	</ul>
            </li>
            <?php
        elseif ($row['Count']==0):
			?>
			<li class="item" data-id="item<?= $row['id'] ?>" data-title="<?= $row['nombre'] ?>" data-url="<?= $row['url'] ?>" data-menumain="<?= $row['mainmenu_id'] ?>" data-type="<?= $row['tipo'] ?>" data-style="<?= $row['style'] ?>" data-img="<?= $row['img'] ?>">
            	<div class="header">
            		<span class="item-title"><?= html_entity_decode($row['nombre']) ?></span> [<?= $type_det ?>]
            	</div>
            	<a class="more" href="#"><span class="arrow-up" style="display: none;">&#9650;</span><span class="arrow-down">&#9660;</span></a>
            	<div class="item-body" style="display: none">
            		<label title="Titulo del Item" for="nombre">Titulo del Item:
            			<input id="item-menu-name-<?= $row['id'] ?>" autocomplete="off"  name="nombre" class="menu_title" type="text" value="<?= $row['nombre'] ?>" required />
            		</label>
            		<?php
            		if($row['tipo']=="per"):
            		?>
            			<label title="URL" for="nombre">URL (incluir http://):
            				<input id="item-menu-url-<?= $row['id'] ?>" autocomplete="off"  name="url" class="menu_url" type="text" value="<?= $row['url'] ?>" required />
            			</label>
            		<?php
								endif;
            		?>
								<label>URL de imagen:
            			<input id="item-menu-img-<?= $row['id'] ?>" autocomplete="off"  name="img" class="menu_img" type="text" value="<?= $row['img'] ?>" required />
            		</label>
            		<label>Clase CSS (Se aplica a los subitems):
            			<input id="item-menu-css-<?= $row['id'] ?>" name="estilo" class="menu_style" type="text" value="<?= $row['style'] ?>" />
            		</label>
            		<button class="button delete">Eliminar</button>
            	</div>
            	<ul class="column item sortable">
            		<?php rb_menus_edition($mainmenu_id, $row['id'], $level + 1) ?>
            	</ul>
            </li>
            <?php
		endif;
	endwhile;
}
?>
