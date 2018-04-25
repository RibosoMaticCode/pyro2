<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

$depa_id = $_GET['depa_id'];

$qp = $objDataBase->Ejecutar("SELECT * FROM ubprovincia WHERE idDepa=".$depa_id);
while($rp = $qp->fetch_assoc()):
?>
<option id="<?= $rp['idProv'] ?>" value="<?= $rp['provincia'] ?>"><?= $rp['provincia'] ?></option>
<?php
endwhile;
?>
