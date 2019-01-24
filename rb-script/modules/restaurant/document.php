<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once 'funcs.php';

$pedido_id = $_GET['pedido_id'];
$qp = $objDataBase->Ejecutar("SELECT * FROM rest_pedido WHERE id=".$pedido_id);
$pedido = $qp->fetch_assoc();
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
              Pedido ID: <strong><?= $pedido['id'] ?></strong> <br />
              Fecha / Hora: <strong><?= rb_sqldate_to($pedido['fecha_registro'], 'd-m-Y / h:m:s') ?></strong> <br />
              Mesa: <strong><?= mesa($pedido['mesa_id'], 'nombre') ?></strong> <br />
            </div>
          </div>
          <table class="rest_tables">
            <tr>
              <th class="plato_nombre">Plato</th>
              <th>Cantidad</th>
              <th>Precio</th>
							<th>Importe</th>
            </tr>
            <?php
						$total = 0;
            $qpd = $objDataBase->Ejecutar("SELECT * FROM rest_pedido_detalles WHERE pedido_id =".$pedido['id']);
            while( $detalle = $qpd->fetch_assoc() ){?>
              <tr>
                <td class="align_left">
                  <?= plato($detalle['plato_id'], 'nombre') ?>
                </td>
                <td>
                  <?= $detalle['cantidad'] ?>
                </td>
                <td>
                  <?= $detalle['precio'] ?>
                </td>
								<td>
									<?php
									$importe = $detalle['precio'] * $detalle['cantidad'];
									$total += $importe;
									?>
                  <?= $importe ?>
                </td>
              </tr>
            <?php } ?>
						<tr>
							<td colspan="3">
								Subtotal
							</td>
							<td>
								S/ <?= round($total - ($total / 1.18), 2) ?>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								IGV
							</td>
							<td>
								S/ <?= round($total/1.18, 2) ?>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								TOTAL
							</td>
							<td>
								S/ <?= round($total, 2) ?>
							</td>
						</tr>
          </table>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>
