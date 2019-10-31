<html>
<head>
  <style type="text/css">
  table td {
      padding: 10px;
      border-bottom: 1px solid #f1f1f1;
      font-size: .9em;
      vertical-align: middle;
      border-right: 1px solid #f1f1f1;
  }

  table {
      margin: 30px 0;
  }

  table{
      border-top: 1px solid #f1f1f1;
      border-left: 1px solid #f1f1f1;
  }
  table tbody tr:nth-of-type(odd) {
      background-color: rgba(0,0,0,.05);
  }
  table {
  	width: 100%;
  	text-align: left;
  	clear: both;
      border-collapse: separate!important;
      border-spacing: 0;
  }
  </style>
</head>
<body>
  <?php
  if ( !defined('ABSPATH') )
  	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

  require_once ABSPATH.'global.php';
  require_once ABSPATH.'rb-script/class/rb-database.class.php';

  $r = $objDataBase->Ejecutar("SELECT * FROM suscriptores");
  $suscriptores = $r->fetch_all(MYSQLI_ASSOC);
  //print_r($suscriptores);
  ?>
  <table>
    <?php
    foreach ($suscriptores as $suscriptor => $value) {
      ?>
      <tr>
        <td>
          Nombre: <?= $value['nombres']?><br />
          Correo: <?= $value['correo']?><br />
          Telefono: <?= $value['telefono']?>
        </td>
      </tr>
      <?php
    }
    ?>
  </table>
</body>
</html>
