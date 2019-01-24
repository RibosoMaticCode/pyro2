<?php
if(!isset($_GET['days'])){
  $days = 7; // semana
}else{
  if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

  require_once ABSPATH.'rb-script/class/rb-database.class.php';
  require_once ABSPATH.'global.php';
  require_once 'funcs.php';

  $objDataBase = new DataBase;
  $days = $_GET['days'];
}
$qlist = $objDataBase->Ejecutar("SELECT *, count(id) as veces FROM crm_visits WHERE DATEDIFF(CURDATE(), fecha_visita) <= $days GROUP BY customer_id");
?>
<script>
  $(document).ready(function() {
    $('#report2').DataTable({
      "language": {
        "url": "resource/datatables/Spanish.json"
      } 
    });
  });
</script>
<table id="report2" class="tables table-striped">
  <thead>
    <tr>
      <th>Cliente</th>
      <th>Numero de visitas</th>
    </tr>
  </thead>
  <tbody>
    <?php
    while ($row = $qlist->fetch_assoc()):
    ?>
    <tr>
      <td><?= crm_customer_fullname($row['customer_id']) ?></td>
      <td><a class="fancyboxForm fancybox.ajax" href="<?= G_SERVER ?>/rb-script/modules/crm/visit.details.php?id=<?= $row['customer_id'] ?>&days=15"><?= $row['veces'] ?></a></td>
    </tr>
    <?php
    endwhile;
    ?>
  </tbody>
</table>