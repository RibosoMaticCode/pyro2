<?php
// Funcion recursiva para crear estructura del menu
function items_recursive($mainmenu_id, $parent, $level){
  global $objDataBase;
  // Lista items de un primer nivel, el campo Count, muestra numero de subitems
  $r = $objDataBase->Ejecutar("SELECT mi.nivel, mi.id, mi.mainmenu_id, mi.nombre, mi.url, mi.tipo, mi.style, mi.img, Items.Count FROM "
    .G_PREFIX."menus_items mi  LEFT OUTER JOIN (SELECT menu_id, COUNT(*) AS Count FROM "
    .G_PREFIX."menus_items GROUP BY menu_id) Items ON mi.id = Items.menu_id WHERE mi.menu_id="
    . $parent." AND mi.mainmenu_id=".$mainmenu_id. " ORDER BY id");

  $menuhtml = '<ul>';
  while($menu_item = $r->fetch_assoc()):
    $menuhtml .= '<li><a href="'.rb_url_link($menu_item['tipo'], $menu_item['url']).'">'.$menu_item['nombre'].'</a>';
    // Si campo Count, contiene items, ejecutara nuevamente la funcion... y asi recursivamente
    if($menu_item['Count']>0){
      $menuhtml .= items_recursive($mainmenu_id, $menu_item['id'], $level+1);
    }
    $menuhtml .= '</li>';
  endwhile;
  $menuhtml .= '</ul>';
  return $menuhtml;
}

// Mostrar items del menu segun su id
function show_menu( $params ){
  $menu_html = '<div class="menu_main">'.items_recursive($params['id'], 0, 0).'</div>';
  $menu_html .= '<a class="btnMenuOpen" href="#">Open Menu</a><a class="btnMenuClose" href="#">Close Menu</a>';
	return $menu_html;
}

/* ---------------- SHORTCODES --------------- */
/*
* Hay que crear los shortcodes para cada menu, ANTES de usarse en el sistema,
* NO DURANTE, pues no es posible cuando se trata de funciones dinamicas.
*/
$r = $objDataBase->Ejecutar('SELECT * FROM '.G_PREFIX.'menus');
while($form = $r->fetch_assoc()){
	add_shortcode('MENU', 'show_menu', ['id' => $form['id'] ]);
}

/*
  Hoja de estilo del menu
*/
function menu_front_files(){
  global $rb_modure_dir;
	$files = "<link rel='stylesheet' href='".G_SERVER."rb-admin/core/menu/menu.front.css'>\n";
  $files .= "<script src='".G_SERVER."rb-admin/core/menu/menu.front.js'></script>\n";
  return $files;
}
add_function('theme_header','menu_front_files');

/*
  Hoja de Javascript
*/
?>
