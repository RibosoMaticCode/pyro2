<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH."rb-script/modules/plm/funcs.php";
$urlreload=G_SERVER.'rb-admin/module.php?pag=plm_config';
?>
<div class="inside_contenedor_frm">
<section class="seccion">
  <div class="seccion-header plm_backend_text">
		<img class="plm_logo" src="<?= G_SERVER ?>rb-script/modules/plm/product.png" alt="info" />
    <h2>PLM - Gestionador de productos</h2>
    <span class="info">Desarrollado por Jesus Liñán para Pyro. <strong>Version <?= get_option('version')?></strong></span>
  </div>
  <div class="seccion-body plm_backend_text">
		<p>Cuenta con las siguientes caracteristicas:</p>
		<ul>
			<li>Gestiona listado de productos con su informacion como: precio, descuento, marca, modelos, detalles, foto y galeria, etc.</li>
			<li>Gestiona categorias y subcategorias de productos</li>
			<li>Listado de productos por categoria.</li>
			<li>Buscador de productos. Y lista resultados.</li>
			<li>Pagina con detalles de cada producto registrado.</li>
			<li>Permite añadir producto a carrito de compra.</li>
			<li>Permite generar una orden del pedido.</li>
			<li>Permite el pago con tarjeta (configurado para culqi.com)</li>
			<li>Añade opcion al panel del usuario final, para ver sus pedido realizados.</li>
			<li>Permite al usuario final escribir su reseña. Y usuario admin moderarlas.</li>
			<li>Añade un widget para mostrar bloques de productos de diferentes diseños.</li>
			<li>Entre otras funciones.</li>
		</ul>
  </div>
</section>
