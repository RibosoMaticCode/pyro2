<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH."rb-script/modules/plm/funcs.php";
$urlreload=G_SERVER.'/rb-admin/module.php?pag=plm_config';
?>
<div class="inside_contenedor_frm">
<section class="seccion">
  <div class="seccion-header">
    <h2>PLM - Gestionador de productos</h2>
    <span class="info">Desarrollado por Jesus Liñán para Blackpyro</span>
  </div>
  <div class="seccion-body">
    <p>Cuenta con las siguientes caracteristicas</p>
		<ul>
<li>Gestiona listado de productos con informaion como precio, descuento, marca, modelos, detalles, foto y galeria, etc.</li>
<li>Gestiona categorias de poroductos</li>
<li>Listado de productos por categoria</li>
<li>Buscador de productos.</li>
<li>Pagina con detalles de cada producto registrado.</li>
<li>Permite añadir producto a carrito de compra.</li>
<li>Permite generar una orden del pedido.</li>
<li>Permite el pago con tarjeta (configurado para culqi.com)</li>
<li>Añade opcion al panel del usuario final, para ver sus pedido realizados.</li>
</ul>
  </div>
</section>
