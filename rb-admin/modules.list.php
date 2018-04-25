<?php
// Cargar los modulos en base de datos
foreach($array_modules as $module => $valor):
	include_once $valor;
endforeach;
?>
