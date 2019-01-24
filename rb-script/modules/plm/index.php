<?php
/*
Module Name: PLM Gestionador de productos de venta
Plugin URI: http://emocion.pe
Description: Crear y muestra detalles de productos o articulos para venta
Author: Jesus Liñan
Version: 1.1
Author URI: http://ribosomatic.com
*/

// Valores iniciales
$rb_modure_dir = "plm";
$rb_module_url = G_SERVER."/rb-script/modules/$rb_modure_dir/";
$rb_module_url_img = G_SERVER."/rb-script/modules/$rb_modure_dir/product.png";

// Ubicacion en el Menu
$menu1 = [
	'key' => 'plm',
	'nombre' => "Gestion de productos",
	'url' => "#",
	'url_imagen' => $rb_module_url_img,
	'pos' => 1,
	'show' => true,
	'item' => [
		[
			'key' => 'plm_products',
			'nombre' => "Productos",
			'url' => "module.php?pag=plm_products",
			'url_imagen' => "none",
			'pos' => 1
		],
		[
			'key' => 'plm_category',
			'nombre' => "Categorias",
			'url' => "module.php?pag=plm_category",
			'url_imagen' => "none",
			'pos' => 2
		],
		[
			'key' => 'plm_orders',
			'nombre' => "Pedidos de compra",
			'url' => "module.php?pag=plm_orders",
			'url_imagen' => "none",
			'pos' => 3
		],
		[
			'key' => 'plm_config',
			'nombre' => "Configuracion",
			'url' => "module.php?pag=plm_config",
			'url_imagen' => "none",
			'pos' => 4
		]
	]
];

$menu = [
	"plm" => $menu1
];

$carrito = [];
if(!isset($_SESSION['carrito'])){
	$_SESSION['carrito'] = $carrito;
}

// Widget
$widget = [
  'link_action' => 'addPlmUrl',
  'dir' => 'plm',
  'name' => 'PLM Url',
  'desc' => 'Url navegacion product',
  'filejs' => 'file.js',
  'img_abs' => $rb_module_url.'widget-url.png'
];
array_push($widgets, $widget);

// Panel de usuario
$menu_plm = [
	[
		'key' => 'pedidos',
		'title' => 'Mis pedidos',
	]
];
array_push($menu_user_panel, $menu_plm); // Agregar al array principal $menu_user_panel

// Titulo de la pagina web
function plm_title(){
	return "Gestion de productos";
}

/* CUSTOMS FUNCTIONS */

// BACKEND //

// CSS
function plm_backend_css(){
	$css = "<link rel='stylesheet' href='".G_DIR_MODULES_URL."plm/product.backend.css'>\n";
	return $css;
}
add_function('panel_header_css','plm_backend_css');

// ------ PRODUCTOS ------ //
if(isset($_GET['pag']) && $_GET['pag']=="plm_products"):
	function plm_products_title(){
		return "Productos";
	}
	function plm_products(){
		global $rb_module_url;
		if(isset($_GET['product_id'])){
			include_once 'product.newedit.php';
		}else{
			include_once 'product.php';
		}
	}
	add_function('module_title_page','plm_products_title');
	add_function('module_content_main','plm_products');
endif;

// FRONTEND //

// ---------- PRODUCTOS ------------ //
// Llamadas por url (o llamadas amigables)
function plm_products_call_url(){
	include_once 'funcs.php';
	// Enlaces amigables
	if(G_ENL_AMIG):
		$requestURI = str_replace(G_DIRECTORY, "", $_SERVER['REQUEST_URI']);
	  $requestURI = explode("/", $requestURI);
		$requestURI = array_values( array_filter( $requestURI ) );
		$numsItemArray = count($requestURI);

		// URL_SERVER/[0]/[1]

		if( $numsItemArray > 0 ):
			if( $requestURI[0] == "products" ):
				$seccion = $requestURI[0];

				if( isset($requestURI[1]) && $requestURI[1]=="category"): // Si es categoria : URL_SERVER/products/category/<categoria>/
					$seccion = "category";
					if( isset($requestURI[2]) ){
						$category = $requestURI[2];
						$category_info = get_category_info($category, true);
						$category = $category_info['id'];
					}else{
						header( 'Location: '.G_SERVER.'/products/');
					}
				elseif( isset($requestURI[1]) && $requestURI[1]=="search"): // Si es busqueda : URL_SERVER/products/search/<termino-a-buscar>/
					$seccion = "search";
					if( isset($requestURI[2]) ){
						$search = $requestURI[2];
					}else{
						header( 'Location: '.G_SERVER.'/products/');
					}
				elseif( isset($requestURI[1]) ): // Si es solo un producto : URL_SERVER/products/<nombre-producto>/
					$product = $requestURI[1];
				endif;
			endif;
			if( $requestURI[0] == "shopping-cart" ):
				$seccion = "cart";
			endif;
			if( $requestURI[0] == "pre-payment" ):
				$seccion = "pre-payment";
			endif;
		endif;
	// Enlaces no amigables
	else:
		if( isset($_GET['products']) ): // URL_SERVER/?products
			$seccion = "products";
			if( $_GET['products']!=""){
				$product = $_GET['products'];
			}
		endif;
		if( isset($_GET['category']) ): // URL_SERVER/?category=<categoria_id>
			$seccion = "category";
			if( $_GET['category']!=""){
				$category = $_GET['category'];
			}
		endif;
		if( isset($_GET['product_search']) ): // URL_SERVER/?product_search=<termino-a-buscar>
			$seccion = "search";
			if( $_GET['product_search']!=""){
				$search = $_GET['product_search'];
			}
		endif;
		if( isset($_GET['shopping-cart']) ):
			$seccion = "cart";
		endif;
		if( isset($_GET['pre-payment']) ):
			$seccion = "pre-payment";
		endif;
	endif;

	global $objDataBase;

	// Mostrar informacion del producto
	if(isset($seccion) && isset($product)):
		if(G_ENL_AMIG):
			$qs = $objDataBase->Ejecutar("SELECT * FROM plm_products WHERE nombre_key='".$product."'");
			$product_catalogue_link = G_SERVER."/products/";
		else:
			$qs = $objDataBase->Ejecutar("SELECT * FROM plm_products WHERE id=".$product);
			$product_catalogue_link = G_SERVER."/?products";
		endif;

		$product = $qs->fetch_assoc();
		$photo = rb_get_photo_details_from_id($product['foto_id']);

		define('rm_title', $product['nombre']." | ".G_TITULO);
		define('rm_title_page', $product['nombre']);
		define('rm_metakeywords', "");
		define('rm_metadescription', ""); //$product['descripcion'] - acortar
		define('rm_metaauthor', G_METAAUTHOR);
		define('rm_page_image', $photo['thumb_url'] );

		$file = ABSPATH.'rb-script/modules/plm/product.front.view.php';
		require_once( $file );

		die();
	endif;

	// Mostrar solo listado por categoria
	if(isset($seccion) && isset($category)):
		$qs = $objDataBase->Ejecutar("SELECT * FROM plm_products WHERE categoria = '$category' AND mostrar=1 ORDER BY id DESC");
		$products = [];
		$i=0;
		while($product = $qs->fetch_assoc()):
			$products[$i]['id'] = $product['id'];
			$products[$i]['nombre'] = $product['nombre'];
			$products[$i]['precio_oferta'] = $product['precio_oferta'];
			$products[$i]['precio'] = $product['precio'];
			$products[$i]['descuento'] = $product['descuento'];
			if(G_ENL_AMIG) $products[$i]['url'] = G_SERVER."/products/".$product['nombre_key']."/";
			else $products[$i]['url'] = G_SERVER."/?products=".$product['id'];
			$photo = rb_get_photo_details_from_id($product['foto_id']);
			$products[$i]['image_url'] = $photo['file_url'];
			$i++;
		endwhile;

		define('rm_title', "Productos | ".G_TITULO);
		define('rm_title_page', "Productos");
		define('rm_metakeywords', "");
		define('rm_metadescription', "Listado de productos");
		define('rm_metaauthor', G_METAAUTHOR);
		define('rm_page_image', '' );

		$file = ABSPATH.'rb-script/modules/plm/product.front.view.list.php';
		require_once( $file );

		die();
	endif;

	// Mostrar solo listado por busqueda
	if(isset($seccion) && isset($search)):
		//$qs = $objDataBase->Ejecutar("SELECT * FROM plm_products WHERE categoria = '$category' AND mostrar=1 ORDER BY id DESC");
		$qs = $objDataBase->Search($search, 'plm_products', ['nombre', 'descripcion', 'marca', 'modelo'], ' AND mostrar=1');
		$CountResult = $qs->num_rows;
		$products = [];
		$i=0;
		while($product = $qs->fetch_assoc()):
			$products[$i]['id'] = $product['id'];
			$products[$i]['nombre'] = $product['nombre'];
			$products[$i]['precio_oferta'] = $product['precio_oferta'];
			$products[$i]['precio'] = $product['precio'];
			$products[$i]['descuento'] = $product['descuento'];
			if(G_ENL_AMIG) $products[$i]['url'] = G_SERVER."/products/".$product['nombre_key']."/";
			else $products[$i]['url'] = G_SERVER."/?products=".$product['id'];
			$photo = rb_get_photo_details_from_id($product['foto_id']);
			$products[$i]['image_url'] = $photo['file_url'];
			$i++;
		endwhile;

		define('rm_title', "Resultado de busqueda | ".G_TITULO);
		define('rm_title_page', "Resultado de busqueda");
		define('rm_metakeywords', "");
		define('rm_metadescription', "Resultado de busqueda");
		define('rm_metaauthor', G_METAAUTHOR);
		define('rm_page_image', '' );

		$file = ABSPATH.'rb-script/modules/plm/product.front.view.list.php';
		require_once( $file );

		die();
	endif;

	// Mostrar carrito de compras
	if(isset($seccion) && $seccion == "cart"):
		$products = [];
		$totsum = 0;
		$i = 0;
		foreach($_SESSION['carrito'] as $codigo => $cantidad){
			$qp = $objDataBase->Ejecutar("SELECT * FROM plm_products WHERE id=".$codigo);
			$product = $qp->fetch_assoc();
			$tot = round($product['precio_oferta'] * $cantidad,2);

			$products[$i]['id'] = $product['id'];
			$products[$i]['nombre'] = $product['nombre'];
			//$products[$i]['precio_oferta'] = $product['precio_oferta'];
			$products[$i]['precio'] = $product['precio_oferta'];
			$products[$i]['cantidad'] = $cantidad;
			$photo = rb_get_photo_details_from_id($product['foto_id']);
			$products[$i]['image_url'] = $photo['file_url'];

			if(G_ENL_AMIG) $products[$i]['url'] = G_SERVER."/products/".$product['nombre_key']."/";
			else $products[$i]['url'] = G_SERVER."/?products=".$product['id'];

			$totsum += $tot;
			$i++;
		}
		if(G_ENL_AMIG) $pre_payment_url = G_SERVER."/pre-payment/";
		else $pre_payment_url = G_SERVER."?pre-payment";

		define('rm_title', "Carrito de compras | ".G_TITULO);
		define('rm_title_page', "Carrito de compras");
		define('rm_metakeywords', "");
		define('rm_metadescription', "Mi carrito de compras");
		define('rm_metaauthor', G_METAAUTHOR);
		define('rm_page_image', '' );

		$file = ABSPATH.'rb-script/modules/plm/cart.front.view.php';
		include_once 'funcs.php';
		require_once( $file );

		die();
	endif;

	// Mostrar un paso previo a pagar: info del usuario y carrito de compras
	if(isset($seccion) && $seccion == "pre-payment"):
		define('rm_title', "Verifique su informacion | ".G_TITULO);
		define('rm_title_page', "Verifique su informacion");
		define('rm_metakeywords', "");
		define('rm_metadescription', "Verifique su informacion antes de realizar el pago");
		define('rm_metaauthor', G_METAAUTHOR);
		define('rm_page_image', '' );

		if(G_ACCESOUSUARIO==0):
			$error_message = "Debe de iniciar sesión";
			$file = ABSPATH.'rb-script/modules/plm/payment.error.php';
			require_once( $file );
			die();
		endif;
		if( !isset($_SESSION['carrito']) || count($_SESSION['carrito'])==0 ):
			$error_message = "Su carrito de compra está vacio";
			$file = ABSPATH.'rb-script/modules/plm/payment.error.php';
			require_once( $file );
			die();
		endif;
		$products = [];
		$totsum = 0;
		$i = 0;
		$user = rb_get_user_info(G_USERID);
		foreach($_SESSION['carrito'] as $codigo => $cantidad){
			$qp = $objDataBase->Ejecutar("SELECT * FROM plm_products WHERE id=".$codigo);
			$product = $qp->fetch_assoc();
			$tot = round($product['precio_oferta'] * $cantidad,2);

			$products[$i]['id'] = $product['id'];
			$products[$i]['nombre'] = $product['nombre'];
			//$products[$i]['precio_oferta'] = $product['precio_oferta'];
			$products[$i]['precio'] = $product['precio_oferta'];
			$products[$i]['cantidad'] = $cantidad;
			$photo = rb_get_photo_details_from_id($product['foto_id']);
			$products[$i]['image_url'] = $photo['file_url'];

			if(G_ENL_AMIG) $products[$i]['url'] = G_SERVER."/products/".$product['nombre_key']."/";
			else $products[$i]['url'] = G_SERVER."/?products=".$product['id'];

			$totsum += $tot;
			$i++;
		}
		if(G_ENL_AMIG) $cart_url = G_SERVER."/shopping-cart/";
		else $cart_url = G_SERVER."/?shopping-cart";

		$panel_user = G_SERVER."/?pa=panel&section=pedidos";

		$file = ABSPATH.'rb-script/modules/plm/cart.pre.payment.php';
		include_once 'funcs.php';
		require_once( $file );

		die();
	endif;

	// Mostrar solo listado -- all products
	if(isset($seccion)):
		$qs = $objDataBase->Ejecutar("SELECT * FROM plm_products WHERE mostrar=1 ORDER BY id DESC");

		$i=0;
		while($product = $qs->fetch_assoc()):
			$products[$i]['id'] = $product['id'];
			$products[$i]['nombre'] = $product['nombre'];
			$products[$i]['precio_oferta'] = $product['precio_oferta'];
			$products[$i]['precio'] = $product['precio'];
			$products[$i]['descuento'] = $product['descuento'];
			if(G_ENL_AMIG) $products[$i]['url'] = G_SERVER."/products/".$product['nombre_key']."/";
			else $products[$i]['url'] = G_SERVER."/?products=".$product['id'];
			$photo = rb_get_photo_details_from_id($product['foto_id']);
			$products[$i]['image_url'] = $photo['file_url'];
			$i++;
		endwhile;

		define('rm_title', "Productos | ".G_TITULO);
		define('rm_title_page', "Productos");
		define('rm_metakeywords', "");
		define('rm_metadescription', "Listado de productos");
		define('rm_metaauthor', G_METAAUTHOR);
		define('rm_page_image', '' );

		$file = ABSPATH.'rb-script/modules/plm/product.front.view.list.php';
		require_once( $file );

		die();
	endif;
}
add_function('call_modules_url','plm_products_call_url');

// CSS Front End
function plm_front_css(){
	$css = "<link rel='stylesheet' href='".G_DIR_MODULES_URL."plm/product.front.css'>\n";
	return $css;
}
add_function('theme_header','plm_front_css');

// SHORT CODE - PRODUCTOS PAGINA INICIAL //

function plm_products_init(){
	global $objDataBase;
	$qs = $objDataBase->Ejecutar("SELECT * FROM plm_products ORDER BY id DESC");
	$products_list = '<div class="cols-container products">';
	while($product = $qs->fetch_assoc()):

		$photo = rb_get_photo_details_from_id($product['foto_id']);
		if(G_ENL_AMIG) $product['url'] = G_SERVER."/products/".$product['nombre_key']."/";
		else $product['url'] = G_SERVER."/?products=".$product['id'];

		$products_list .= '<div class="cols-3-md">
		<div class="product-item">
			<div class="product-item-cover-img" style="background-image:url(\''.$photo['file_url'].'\')">
			</div>
			<div class="product-item-desc">
				<h3>'.$product['nombre'].'</h3>
				<div class="product-item-price">';
					if($product['precio']>0):
						$products_list .='<span class="product-item-price-before">Tienda: S/. '.$product['precio'] .'</span>
                    <span>Online: </span>';
                    endif;
					$products_list .='<span class="product-item-price-now">S/.'.$product['precio_oferta'].'</span>
				</div>
			</div>
			<a href="'.$product['url'].'">Ver detalles</a>
		</div>
	</div>';
	endwhile;
	$products_list .= '</div>';
	return $products_list;
}

add_shortcode('products_init','plm_products_init');

// SHORTCODE : LINK DE CARRITO DE COMPRAS
function plm_cart_link(){
	if(G_ENL_AMIG) $urlreload = G_SERVER."/shopping-cart/";
	else $urlreload = G_SERVER."/?shopping-cart";
	if(isset($_SESSION['carrito'])){
		$cant = count($_SESSION['carrito']);
		$cart_link = '<a href="'.$urlreload.'">Ver carrito (<span id="cart_count">'.$cant.'</span>)</a>';
	}else{
		$cart_link = '<a href="'.$urlreload.'">Ver carrito</a>';
	}
	return $cart_link;
}

add_shortcode('cart_link', 'plm_cart_link');

// SHORTCODE : FORMULARIO DE BUSQUEDA

function plm_frm_search_products(){
	$frm_search = '
	<div class="plm_cover_frm_search">
		<form id="plm_frm_search" action="'.G_SERVER.'/rb-script/modules/plm/product.search.php" method="get">
			<input type="text" name="plm_product_term" />
			<button>Buscar</button>
		</form>
	</div>';
	return $frm_search;
}

add_shortcode('frm_search_products', 'plm_frm_search_products');

// ------ CONFIGURACIN PRODUCTOS ------ //
if(isset($_GET['pag']) && $_GET['pag']=="plm_config"):
	function plm_config_title(){
		return "Configuracion de PLM";
	}
	function plm_config(){
		global $rb_module_url;
		include_once 'config.php';
	}
	add_function('module_title_page','plm_config_title');
	add_function('module_content_main','plm_config');
endif;

// ------ PEDIDOS DE PRODUCTOS ------ //
if(isset($_GET['pag']) && $_GET['pag']=="plm_orders"):
	function plm_orders_title(){
		return "Configuracion de PLM";
	}
	function plm_orders(){
		global $rb_module_url;
		include_once 'orders.php';
	}
	add_function('module_title_page','plm_orders_title');
	add_function('module_content_main','plm_orders');
endif;

// ------ CATEGORIAS DE PRODUCTOS ------ //
if(isset($_GET['pag']) && $_GET['pag']=="plm_category"):
	function plm_category_title(){
		return "Categorias";
	}
	function plm_category(){
		global $rb_module_url;
		include_once 'category.init.php';
	}
	add_function('module_title_page','plm_category_title');
	add_function('module_content_main','plm_category');
endif;

// Configurador de widget
function plm_url_config(){
	global $rb_module_url;
	include_once 'widget.url.config.php';
}
add_function('modals-config','plm_url_config');


// PARA LA SECCION PANEL DEL USUARIO
function plm_userpanel(){
	include_once 'user.panel.php';
}

add_function('panel_user_section','plm_userpanel');
