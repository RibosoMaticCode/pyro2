<style>
  pre{
    font-size: .85em;
    background-color: #000;
    padding: 10px;
    color:#fff;
  }
</style>
<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(__FILE__)) . '/');

require_once ABSPATH.'rb-admin/hook.php';
require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funciones.php';

// Carga lista de modulos en formato Json desde la DB
$modules_prev = rb_get_values_options('modules_load');

// Convierte json a array php
$array_modules = json_decode($modules_prev, true);

// Lista de modulos y sus rutas
echo "Ubicacion de modulos<pre>";
print_r($array_modules);
echo "</pre>";

// Carga las funciones pesonalizadas de los modulos
require_once ABSPATH.'rb-admin/modules.list.php';

echo "Ubicacion y funcion enlazada<pre>";
print_r($hooks);
echo "</pre>";

echo "Shortcodes<pre>";
print_r($shortcodes);
echo "</pre>";

echo "BB codes<pre>";
print_r($bb_codes);
echo "</pre>";
