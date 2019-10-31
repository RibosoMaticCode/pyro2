<?php
// Incluir modulos independiente a traves de codigo
include_once ABSPATH.'rb-admin/core/grupos/group.php';
include_once ABSPATH.'rb-admin/core/forms/forms.php';

// Cargar los modulos en base de datos
foreach($array_modules as $module => $valor):
	include_once $valor;
endforeach;
?>
