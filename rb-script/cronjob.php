<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(__FILE__)) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

// Establecer los archivos que contienen funciones a ejecutar
require_once ABSPATH.'rb-script/modules/crm_ersil/cron.functions.php';


// Funcion a ejecutar
//writeinfile();

notify_by_mail();