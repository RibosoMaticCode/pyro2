<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$prov_id = $_GET['prov_id'];

$qd = $objDataBase->Ejecutar("SELECT * FROM ubdistrito WHERE idProv=".$prov_id);
while($rd = $qd->fetch_assoc()):
?>
<option id="<?= $rd['idDist'] ?>" value="<?= $rd['distrito'] ?>"><?= $rd['distrito'] ?></option>
<?php
endwhile;
?>
