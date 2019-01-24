<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once 'funcs.php';

$id = $_GET['id'];
$days = $_GET['days'];
$q = count_last_days($id, $days);
?>
<h3><?= crm_customer_fullname($id) ?></h3>
<table class="tables">
    <tr>
        <th>Fecha</th>
        <th>Detalles</th>
    </tr>
    <?php
    while($visit = $q->fetch_assoc()){
        ?>
        <tr>
            <td><?= rb_sqldate_to($visit['fecha_visita']) ?></td>
            <td><?= $visit['observaciones'] ?></td>
        </tr>
        <?php
    }
    ?>
</table>