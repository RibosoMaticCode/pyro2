<?php
//include 'islogged.php';
/* LISTADO DE MODULOS */
//include_once ABSPATH.'rb-admin/core/grupos/group.php';

// Cargar los modulos en base de datos
foreach($array_modules as $module => $valor):
	include_once $valor;
endforeach;
?>
