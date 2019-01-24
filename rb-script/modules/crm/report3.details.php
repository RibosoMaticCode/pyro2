<?php
if(!isset($_GET['days'])){
  $days = 30; // semana
}else{
  if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

  require_once ABSPATH.'rb-script/class/rb-database.class.php';
  require_once ABSPATH.'global.php';
  require_once 'funcs.php';

  $objDataBase = new DataBase;
  $days = $_GET['days'];
}
$qlist = $objDataBase->Ejecutar("SELECT t1.customer_id, t1.fecha_visita, t1.observaciones, DATE_SUB(NOW(), INTERVAL $days DAY) AS fecha30, DATEDIFF(NOW(), t1.fecha_visita) as diff FROM crm_visits AS t1 INNER JOIN ( SELECT customer_id, MAX(fecha_visita) as fecha FROM crm_visits GROUP BY customer_id) as t2 ON t1.fecha_visita = t2.fecha AND t1.customer_id = t2.customer_id WHERE t1.fecha_visita < DATE_SUB(NOW(), INTERVAL $days DAY)");
?>
<script>
  $(document).ready(function() {
    $('#report3').DataTable({
      "language": {
        "url": "resource/datatables/Spanish.json"
      } 
    });
  });
</script>
<table id="report3" class="tables table-striped">
  <thead>
    <tr>
      <th>Cliente</th>
      <th>Ultima visita</th>
      <th>Días desde su ultima visita</th>
    </tr>
  </thead>
  <tbody>
    <?php
    while ($row = $qlist->fetch_assoc()):
    ?>
    <tr>
      <td><?= crm_customer_fullname($row['customer_id']) ?></td>
      <td><?= $row['fecha_visita'] ?></td>
      <td><?= $row['diff'] ?></td>
    </tr>
    <?php
    endwhile;
    ?>
  </tbody>
</table>