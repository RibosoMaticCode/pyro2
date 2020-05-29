<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

function get_option($option){
  global $objDataBase;
  $r = $objDataBase->Ejecutar("SELECT plm_value FROM plm_config WHERE plm_option='".$option."'");
  $option = $r->fetch_assoc();
  return rb_BBCodeToGlobalVariable($option['plm_value']);
}

// INFORMACION DEL PRODUCTO
function get_product_info($product_id){
	global $objDataBase;
	$r = $objDataBase->Ejecutar("SELECT * FROM plm_products WHERE id=".$product_id);
	if($r->num_rows == 0){
		return false;
	}
	$product = $r->fetch_assoc();
	if(G_ENL_AMIG):
		$product['url']=G_SERVER."products/".$product['nombre_key']."/";
	else:
		$product['url']=G_SERVER."?products=".$product['id'];
	endif;
	return $product;
}

// INFORMACION DE LA CATEGORIA
function get_category_info($category_id, $bykey = false){
	global $objDataBase;
	if($bykey){
		$r = $objDataBase->Ejecutar("SELECT * FROM plm_category WHERE nombre_enlace='".$category_id."'");
	}else{
		if(!is_numeric ($category_id)) return false;
		$r = $objDataBase->Ejecutar("SELECT * FROM plm_category WHERE id=".$category_id);
	}

  $category = $r->fetch_assoc();

	if(G_ENL_AMIG):
		$Category['url'] = G_SERVER."products/category/".$category['nombre_enlace']."/";
	else:
	  $Category['url'] = G_SERVER."?category=".$category['id'];
	endif;
	$Category['id'] = $category['id'];
	$Category['nombre'] = $category['nombre'];
	$Category['foto_id'] = $category['foto_id'];
	$Category['descripcion'] = $category['descripcion'];

  return $Category;
}

// LISTADO DE PRODUCTOS RECIENTES
function products_recent($limit=5){
	global $objDataBase;
	$qs = $objDataBase->Ejecutar("SELECT * FROM plm_products WHERE mostrar=1 ORDER BY id DESC LIMIT $limit");

	$i=0;
	while($product = $qs->fetch_assoc()):
		$products[$i]['id'] = $product['id'];
		$products[$i]['nombre'] = $product['nombre'];
		$products[$i]['precio_oferta'] = $product['precio_oferta'];
		$products[$i]['precio'] = $product['precio'];
		$products[$i]['descuento'] = $product['descuento'];
		if(G_ENL_AMIG) $products[$i]['url'] = G_SERVER."products/".$product['nombre_key']."/";
		else $products[$i]['url'] = G_SERVER."?products=".$product['id'];
		$photo = rb_get_photo_details_from_id($product['foto_id']);
		$products[$i]['image_url'] = $photo['file_url'];
		$i++;
	endwhile;
	return $products;
}

// LISTADO DE PRODUCTOS RELACIONADOS
function products_related($product_id, $limit=5){
	global $objDataBase;
	// Info del producto
	$qp = $objDataBase->Ejecutar("SELECT * FROM plm_products WHERE id=$product_id");
	$product_info = $qp->fetch_assoc();
	$search = rb_cambiar_nombre($product_info['nombre']." ".$product_info['marca']." ".$product_info['modelo']); // Concatenamos informarcion a buscar

	$qs = $objDataBase->Search($search, 'plm_products', ['nombre', 'descripcion', 'marca', 'modelo'], " AND mostrar=1 AND id <> $product_id LIMIT $limit");
	if($qs->num_rows == 0) return false;
	$i=0;
	while($product = $qs->fetch_assoc()):
		$products[$i]['id'] = $product['id'];
		$products[$i]['nombre'] = $product['nombre'];
		$products[$i]['precio_oferta'] = $product['precio_oferta'];
		$products[$i]['precio'] = $product['precio'];
		$products[$i]['descuento'] = $product['descuento'];
		if(G_ENL_AMIG) $products[$i]['url'] = G_SERVER."products/".$product['nombre_key']."/";
		else $products[$i]['url'] = G_SERVER."?products=".$product['id'];
		$photo = rb_get_photo_details_from_id($product['foto_id']);
		$products[$i]['image_url'] = $photo['file_url'];
		//$products[$i]['tipo'] = $product['tipo'];
		$i++;
	endwhile;
	return $products;
}

// LISTADO DE CATEGORIAS
function list_category($parent_id){
	global $objDataBase;

	$array_main = [];

	$result = $objDataBase->Ejecutar("SELECT c.id, c.nombre, c.nombre_enlace, c.descripcion, c.foto_id, c.islink, SubTable.Count FROM `plm_category` c
    LEFT OUTER JOIN (SELECT parent_id, COUNT(*) AS Count FROM `plm_category` GROUP BY parent_id) SubTable ON c.id = SubTable.parent_id
    WHERE c.parent_id=". $parent_id);

	while ($row = $result->fetch_assoc()):
		if(G_ENL_AMIG):
			$url = G_SERVER."products/category/".$row['nombre_enlace']."/";
		else:
			$url = G_SERVER."?category=".$row['id'];
		endif;
		if ($row['Count'] > 0) {
			$array = [
				'id' => $row['id'],
				'nombre' => $row['nombre'],
				'nombre_enlace' => $row['nombre_enlace'],
				'descripcion' => $row['descripcion'],
				'foto_id' => $row['foto_id'],
				'url' => $url,
				'islink' => $row['islink'],
				'items' => list_category( $row['id'] )
			];
		}elseif ($row['Count']==0) {
			$array = [
				'id' => $row['id'],
				'nombre' => $row['nombre'],
				'nombre_enlace' => $row['nombre_enlace'],
				'descripcion' => $row['descripcion'],
				'foto_id' => $row['foto_id'],
				'url' => $url,
				'islink' => $row['islink']
			];

		}
		array_push($array_main, $array);
	endwhile;

	return $array_main;
}

// BORRAR CATEGORIA POR ID, Y SUS SUBCATEGORIAS
function delete_category($categoria_id){
	global $objDataBase;
	$r = $objDataBase->Ejecutar("SELECT a.id, a.nombre, subcat.Count FROM plm_category a
		LEFT OUTER JOIN (SELECT parent_id, COUNT(*) AS Count FROM plm_category GROUP BY parent_id) subcat ON a.id = subcat.parent_id
		WHERE a.parent_id=" . $categoria_id);

 	while ($row = $r->fetch_assoc()) {
 		if ($row['Count'] > 0) {
			delete_category($row['id']);
 			$r = $objDataBase->Ejecutar("DELETE FROM plm_category WHERE id=".$row['id']);
			if(!$r) return false;
 		}elseif ($row['Count']==0) {
 			$objDataBase->Ejecutar("DELETE FROM plm_category WHERE id=".$row['id']);
			if(!$r) return false;
 		}
	}
	return true;
}

// LISTADO DE COMENTARIOS, SEGUN ID DEL PRODUCTO
function review_list($product_id=0){
	global $objDataBase;
	if($product_id > 0){
		$qr = $objDataBase->Ejecutar("SELECT * FROM plm_comments WHERE product_id = $product_id ORDER BY date_register DESC");
	}else{
		$qr = $objDataBase->Ejecutar("SELECT * FROM plm_comments ORDER BY date_register DESC");
	}
	$comments = $qr->fetch_all(MYSQLI_ASSOC);
	return $comments;
}

// URL DE PAGINACION SEGUN CATEGORIA, BUSQUEDA, ETC
function url_page($term, $page, $type){
	switch ($type) {
		case 'cat':
			$category = get_category_info($term);
			if(G_ENL_AMIG){
				if($page==1){
					return $category['url'];
				}else{
					return $category['url'].$page.'/';
				}
			}else{
				if($page==1){
					return $category['url'];
				}else{
					return $category['url'].'&p='.$page;
				}
			}
			break;

		case 'search':
			if(G_ENL_AMIG){
				if($page==1){
					return G_SERVER."products/search/".$term."/";
				}else{
					return G_SERVER."products/search/".$term."/".$page."/";
				}
			}else{
				if($page==1){
					return G_SERVER."?product_search=".$term;
				}else{
					return G_SERVER."?product_search=".$term."&p=".$page;
				}
			}
			break;

		case 'all':
			if(G_ENL_AMIG){
				if($page==1){
					return G_SERVER."products/";
				}else{
					return G_SERVER."products/".$page."/";
				}
			}else{
				if($page==1){
					return G_SERVER."?products";
				}else{
					return G_SERVER."?product&p=".$page;
				}
			}
		break;
	}
}

// VERIFICA SI TIENE VARIANTES, Y OBTIENE OTROS DATOS
function product_have_variants($product_id){
	global $objDataBase;
	$response = [];
	$qv = $objDataBase->Ejecutar("SELECT * FROM plm_products_variants WHERE product_id =".$product_id);
	if($qv->num_rows > 0){
		$variant = $qv->fetch_assoc();
		if($variant['price_discount'] > 0){
			$colname = "price_discount";
		}else{
			$colname = "price";
		}
		$qmaxp = $objDataBase->Ejecutar("SELECT MAX($colname) AS price_max FROM plm_products_variants WHERE product_id =".$product_id);
		$price= $qmaxp->fetch_assoc();
		$pricemax = $price['price_max'];

		$qminp = $objDataBase->Ejecutar("SELECT MIN($colname) AS price_min FROM plm_products_variants WHERE product_id =".$product_id);
		$price= $qminp->fetch_assoc();
		$pricemin = $price['price_min'];

		$response=[
			'result' => true,
			'price_max' => $pricemax,
			'price_min' => $pricemin
		];
	}else{
		$response=[
			'result' => false
		];
	}
	return $response;
}
?>
