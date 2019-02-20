<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

function get_option($option){
  global $objDataBase;
  $r = $objDataBase->Ejecutar("SELECT plm_value FROM plm_config WHERE plm_option='".$option."'");
  $option = $r->fetch_assoc();
  return rb_BBCodeToGlobalVariable($option['plm_value']);
}

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
		$Category['url'] = G_SERVER."/products/category/".$category['nombre_enlace']."/";
	else:
	  $Category['url'] = G_SERVER."/?category=".$category['id'];
	endif;
	$Category['id'] = $category['id'];
	$Category['nombre'] = $category['nombre'];
	$Category['foto_id'] = $category['foto_id'];
	$Category['descripcion'] = $category['descripcion'];

  return $Category;
}

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
		if(G_ENL_AMIG) $products[$i]['url'] = G_SERVER."/products/".$product['nombre_key']."/";
		else $products[$i]['url'] = G_SERVER."/?products=".$product['id'];
		$photo = rb_get_photo_details_from_id($product['foto_id']);
		$products[$i]['image_url'] = $photo['file_url'];
		$i++;
	endwhile;
	return $products;
}

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
		if(G_ENL_AMIG) $products[$i]['url'] = G_SERVER."/products/".$product['nombre_key']."/";
		else $products[$i]['url'] = G_SERVER."/?products=".$product['id'];
		$photo = rb_get_photo_details_from_id($product['foto_id']);
		$products[$i]['image_url'] = $photo['file_url'];
		$i++;
	endwhile;
	return $products;
}

function list_category($parent_id){
	global $objDataBase;

	$array_main = [];

	$result = $objDataBase->Ejecutar("SELECT c.id, c.nombre, c.nombre_enlace, c.descripcion, c.foto_id, SubTable.Count FROM `plm_category` c
    LEFT OUTER JOIN (SELECT parent_id, COUNT(*) AS Count FROM `plm_category` GROUP BY parent_id) SubTable ON c.id = SubTable.parent_id
    WHERE c.parent_id=". $parent_id);

	while ($row = $result->fetch_assoc()):
		if ($row['Count'] > 0) {
			$array = [
				'id' => $row['id'],
				'nombre' => $row['nombre'],
				'nombre_enlace' => $row['nombre_enlace'],
				'descripcion' => $row['descripcion'],
				'foto_id' => $row['foto_id'],
				'items' => list_category( $row['id'] )
			];
		}elseif ($row['Count']==0) {
			$array = [
				'id' => $row['id'],
				'nombre' => $row['nombre'],
				'nombre_enlace' => $row['nombre_enlace'],
				'descripcion' => $row['descripcion'],
				'foto_id' => $row['foto_id']
			];

		}
		array_push($array_main, $array);
	endwhile;

	return $array_main;
}

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

function url_category_page($category_id, $page){
	$category = get_category_info($category_id);
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
}
?>
