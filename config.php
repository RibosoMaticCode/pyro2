<?php
//nombre del servidor
define('G_SERVIDOR','localhost');

//nombre de la base de datos
define('G_BASEDATOS','pyro3_test2');

//nombre del usuario
define('G_USUARIO','root');

//clave del usuario
define('G_CLAVE','');

// +++++++++++++++++++++++++++++++++++++++++++++//
// + Si usa servicios de amazon en la nube AWS +//
// + Usar estas variables de entorno           +//
// +++++++++++++++++++++++++++++++++++++++++++++//

/*
//nombre del servidor
define('G_SERVIDOR', $_SERVER['RDS_HOSTNAME']);

//nombre del usuario
define('G_USUARIO', $_SERVER['RDS_USERNAME']);

//clave del usuario
define('G_CLAVE', $_SERVER['RDS_PASSWORD']);

//nombre de la base de datos
define('G_BASEDATOS', $_SERVER['RDS_DB_NAME']);
*/

// +++++++++++++++++++++++++++++++++++++++++++++//
// ++++         Azure in APP MySQL        ++++ //
// +++++++++++++++++++++++++++++++++++++++++++++//
/*
$connectstr_dbhost = '';
$connectstr_dbname = '';
$connectstr_dbusername = '';
$connectstr_dbpassword = '';

foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_") !== 0) {
        continue;
    }

    $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
    $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
}

//nombre del servidor
define('G_SERVIDOR', $connectstr_dbhost);

//nombre del usuario
define('G_USUARIO',$connectstr_dbusername);

//clave del usuario
define('G_CLAVE',$connectstr_dbpassword);

//nombre de la base de datos
define('G_BASEDATOS',$connectstr_dbname);
*/
?>
