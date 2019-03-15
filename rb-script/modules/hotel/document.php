<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once 'funcs.php';

$reservacion_id = $_GET['reservacion_id'];
$qp = $objDataBase->Ejecutar("SELECT * FROM hotel_reservacion WHERE id=".$reservacion_id);
$reservacion = $qp->fetch_assoc();
?>
<html>
<head>
	<style>
		body {
				width: 100%;
				height: 100%;
				margin: 0;
				padding: 0;
				/*background-color: #FAFAFA;*/
				font: 12pt "Tahoma";
		}
		* {
				box-sizing: border-box;
				-moz-box-sizing: border-box;
		}
		.page {
				width: 210mm;
				min-height: 297mm;
				padding: 20mm;
				margin: 10mm auto;
				border: 1px #D3D3D3 solid;
				border-radius: 5px;
				background: white;
				box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
		}
		.subpage {
				/*padding: 1cm;*/
				/*border: 5px red solid;*/
				height: 257mm;
				/*outline: 2cm #FFEAEA solid;*/
		}

		@page {
				size: A4;
				margin: 0;
		}
		@media print {
				html, body {
						width: 210mm;
						height: 297mm;
				}
				.page {
						margin: 0;
						border: initial;
						border-radius: initial;
						width: initial;
						min-height: initial;
						box-shadow: initial;
						background: initial;
						page-break-after: always;
				}
		}
		table.tables {
		  width: calc(100% - 10mm);
		  position:  absolute;
		  top: 32mm;
		  border-left: 1px solid gray;
		  border-top: 1px solid gray;
		}

		table.tables td {
		  font-size: .7em;
		}

		table.tables th,
		table.tables td {
		  font-size: .7em;
		  border-right: 1px solid gray;
		  border-bottom: 1px solid gray;
		  padding: .5mm 0;
			text-align: center;
		}
		.label {
	    position:  absolute;
	    font-size: .75em;
	    font-weight: bold;
		}
	</style>
	<script>
		//window.print();
	</script>
</head>
<body>
  <div class="pedido_live">
    <table class="rest_tables">
      <tr>
        <td class="align_left">
          <div class="cols-container">
            <div class="cols-12-md">
							<?php
							$habitacion = get_rows('hotel_habitacion',$reservacion['habitacion_id']);
						  $cliente = get_rows('crm_customers',$reservacion['cliente_id']);
							?>
              Reservacion ID: <strong><?= $reservacion['codigo_unico'] ?></strong> <br />
              Fecha / Hora: <strong><?= rb_sqldate_to($reservacion['fecha_registro'], 'd-m-Y / h:m:s') ?></strong> <br />
							Cliente: <strong><?= $cliente['nombres'] ?> <?= $cliente['apellidos'] ?></strong><br />
              Habitacion: <strong><?= $habitacion['numero_habitacion'] ?></strong> <br />
							Estadia:<br />
							- Desde: <strong><?= rb_sqldate_to($reservacion['fecha_ocupado'], 'd-m-Y H:i') ?></strong><br />
							- Hasta: <strong><?= rb_sqldate_to($reservacion['fecha_finalizacion'], 'd-m-Y H:i') ?></strong><br />
							Total habitacion: <strong>S/. <?= $reservacion['total_habitacion'] ?></strong><br />
							Adicionales: <strong>S/. <?= $reservacion['total_adicionales'] ?></strong><br />
							Total final: <strong>S/. <?= $reservacion['total_reservacion'] ?></strong><br />
            </div>
          </div>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>
