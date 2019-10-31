<?php
// El script genera una menu editado en formato json.
// Editar el orden y otros en la funcion rb_menu_panel()
require_once("../rb-script/funcs.php");
require_once("../rb-script/class/rb-database.class.php");
echo '<pre>';
print_r( rb_menu_panel() );
echo '</pre>';
echo json_encode( rb_menu_panel());
?>
