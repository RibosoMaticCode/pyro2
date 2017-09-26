<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

if(!isset($_GET['cte'])) $cte = "";
else $cte = $_GET['cte'];

if(!isset($_GET['control_id'])) $cte = "";
else $cte_id = $_GET['control_id'];


?>
