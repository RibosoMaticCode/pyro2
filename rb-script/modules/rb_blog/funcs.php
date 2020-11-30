<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

// Obtener option
function blog_get_option($option){
  global $objDataBase;
  $r = $objDataBase->Ejecutar("SELECT blog_value FROM blog_config WHERE blog_option='".$option."'");
  $option = $r->fetch_assoc();
  return rb_BBCodeToGlobalVariable($option['blog_value']);
}

// Establecer option
function blog_set_option($option, $new_value){
	global $objDataBase;
	// Verirficamos existencia
	$r = $objDataBase->Ejecutar("SELECT blog_value FROM blog_config WHERE blog_option='".$option."'");
  if($r->num_rows==0){
		$q = $objDataBase->Ejecutar("INSERT INTO blog_config (blog_option, blog_value) VALUES ('$option', '$new_value')");
		return $q;
	}else{
		$q = $objDataBase->Ejecutar("UPDATE blog_config SET blog_value='".$new_value."' WHERE blog_option='".$option."'");
		return $q;
	}
}

// Lista categorias en el panel administrativo - revisar esta funcion, es obsoleta
function rb_listar_categorias($id_padre){ // antes listar_categorias
	global $objDataBase;
	/*require_once("../rb-script/class/rb-categorias.class.php");
	$objCategoria = new Categorias;*/
	$consultaSecc = $objDataBase->Ejecutar("SELECT * FROM blog_categories ORDER BY nombre");

	while ( $categoria = $consultaSecc->fetch_assoc() ){
		$categoria_array[$categoria["id"]] = array(
			"id" => $categoria["id"],
			"nombre" => $categoria["nombre"],
			"descripcion" => rb_fragment_text($categoria["descripcion"],30),
			"acceso" => $categoria["acceso"],
			"niveles" => $categoria["niveles"],
			"categoria_id" => $categoria["categoria_id"],
			"nivel" => $categoria["nivel"],
		);
	}

	if(!isset($categoria_array)) return;

	foreach($categoria_array as $key => $value){
		if ($value["categoria_id"] == $id_padre){
			if($id_padre == 0){
				echo "
				 <tr>
      		<td><a title='Agregar una subcategoria' href='../rb-admin/module.php?pag=rb_blog_category&cat_id=0&parent_id=".$value['id']."&niv=".($value['nivel']+1)."'><img width=\"16px\" height=\"16px\" style=\"border:0px;\" src=\"img/add-black-16.png\" alt=\"Agregar Sub Categoria\" /></a>  ".$value['nombre']."</td>
					<td>".rb_fragment_letters($value['descripcion'],50)."</td>
					<td>".rb_showvisiblename($value['acceso'])."</td>
					<td>".rb_niveltoname($value['niveles'])."</td>
          <td><a target='_blank' href='".G_SERVER."?cat=".$value['id']."'>Link</a></td>
					<td width='40px;'>
					<span>
					<a title=\"Editar\" href='".G_SERVER."rb-admin/module.php?pag=rb_blog_category&cat_id=".$value['id']."'>
					<img style=\"border:0px;\" src=\"img/edit-black-16.png\" alt=\"Editar\" /></a>
					</span>
					</td>

					<td width='40px;'>
					<span>
					<a href=\"#\" title=\"Eliminar\" class=\"del-item\" data-id=\"".$value['id']."\">
					<img src=\"img/del-black-16.png\" alt=\"Eliminar\" /></a>
					</span>
					</td>\n
    			</tr>";
				rb_listar_categorias($key);
			}else{
				echo "
				 <tr>
      		<td>".str_repeat('- - ', $value['nivel'])."<a title='Agregar una subcategoria' href='../rb-admin/module.php?pag=rb_blog_category&cat_id=0&parent_id=".$value['id']."&niv=".($value['nivel']+1)."'><img style=\"border:0px;\" src=\"img/add-black-16.png\" width=\"16px\" height=\"16px\" alt=\"Agregar Sub Categoria\" /></a>  ".$value['nombre']."</td>
					<td>".rb_fragment_letters($value['descripcion'],50)."</td>
					<td>".rb_showvisiblename($value['acceso'])."</td>
					<td>".rb_niveltoname($value['niveles'])."</td>
          <td><a target='_blank' href='".G_SERVER."?cat=".$value['id']."'>Link</a></td>
					<td width='40px;'>
					<span>
					<a title=\"Editar\" href='".G_SERVER."rb-admin/module.php?pag=rb_blog_category&cat_id=".$value['id']."'>
					<img style=\"border:0px;\" src=\"img/edit-black-16.png\" alt=\"Editar\" /></a>
					</span>
					</td>
					<td width='40px;'>
					<span>
					<a href=\"#\" title=\"Eliminar\" class=\"del-item\" data-id=\"".$value['id']."\">
					<img src=\"img/del-black-16.png\" alt=\"Eliminar\" /></a>
					</span>
					</td>\n
    			</tr>";
				rb_listar_categorias($key);
			}
		}
	}
}

/* Muestra ruta/ubicacion de categorias padres
 * Parametros:
 * 		@$category_id -> id de la categoria que deseamos buscar su ancestros.
 *    @path -> variable interna para almacenar la ruta consultada de momento
 * */

function rb_path_categories($category_id,$path=""){
	global $objDataBase;
  $q = $objDataBase->Ejecutar("SELECT * FROM blog_categories WHERE id=$category_id");
  $r = $q->fetch_assoc();
  $path = $r['nombre'].'/'.$path;
  if($r['nivel']==0):
    // Alcanza el top, sale
    echo $path;
    return;
  else:
    // caso contrario, imprime nombre de categoria, y busca datos de su padre
    rb_path_categories($r['categoria_id'],$path);
  endif;
}

/* CAPTURA CONSULTA Y ENVIA UN ARRAY CON DATOS DE LA PUBLICACION - TODA CONSULTA DE LISTADO DE POST DEBE USAR ESTA FUNCION*/
function rb_return_post_array($qa){
	$PostsArray = array();
	$i=0;
	//while($Posts = mysql_fetch_array($qa)):
  while($Posts = $qa->fetch_array(MYSQLI_ASSOC)): // funciona tbm fetch_assoc()
		$PostsArray[$i]['id'] = $Posts['id'];
    $PostsArray[$i]['titulo_id'] = $Posts['titulo_enlace'];
		$PostsArray[$i]['autor_id'] = $Posts['autor_id'];
    $User = rb_get_user_info($Posts['autor_id']);
		$PostsArray[$i]['autor_names'] = $User['nombrecompleto'];
		$PostsArray[$i]['titulo'] = $Posts['titulo'];
		$PostsArray[$i]['contenido'] = $Posts['contenido'];
		$PostsArray[$i]['vistas'] = $Posts['lecturas'];
		//$PostsArray[$i]['comentarios'] = rb_get_num_comments_by_post_id($Posts['id']);
		$PostsArray[$i]['url'] = rb_url_link_blog( 'art' , $Posts['id'] );
		$PostsArray[$i]['fecha'] = $Posts['fecha_dia']." de ".rb_mes_nombre( $Posts['fecha_mes'] ).", ". $Posts['fecha_anio'];
		$PostsArray[$i]['fec_dia'] = isset( $Posts['fecha_dia'] ) ? $Posts['fecha_dia'] : "";
		$PostsArray[$i]['fec_mes'] = isset( $Posts['fecha_mes'] ) ? $Posts['fecha_mes'] : "";
		$PostsArray[$i]['fec_mes_l'] = rb_mes_nombre( isset( $Posts['fecha_mes'] ) ? $Posts['fecha_mes'] : "" );
		$PostsArray[$i]['fec_anio'] = isset( $Posts['fecha_anio'] ) ? $Posts['fecha_anio'] : "";
    $img_back_id = $Posts['img_back'];
		$img_profile_id = $Posts['img_profile'];
		$photo_back = rb_get_photo_details_from_id($img_back_id);
		$photo_profile = rb_get_photo_details_from_id($img_profile_id);
		$PostsArray[$i]['url_img_por_max'] = $photo_back['file_url'];
		$PostsArray[$i]['url_img_por_min'] = $photo_back['thumb_url'];
		$PostsArray[$i]['url_img_pri_max'] = $photo_profile['file_url'];
		$PostsArray[$i]['url_img_pri_min'] = $photo_profile['thumb_url'];
		$i++;
	endwhile;
	return $PostsArray;
}

function rb_post_related_by_category($Post_id, $Category_id,  $Limit = 5){
  global $objDataBase;
	$qa = $objDataBase->Ejecutar("SELECT a.* FROM blog_posts a, blog_posts_categories ac, blogs_categories c WHERE a.id=ac.articulo_id AND ac.categoria_id=c.id AND a.activo='A' AND c.id = ".$Category_id." AND a.id <> ".$Post_id." ORDER BY RAND() LIMIT $Limit");
	return rb_return_post_array($qa);
}

function rb_show_post($post_id, $redirect=true){
	global $objDataBase;
	if( G_ENL_AMIG == 1 ):
		if($redirect){
			$q = $objDataBase->Ejecutar("SELECT id FROM blog_posts WHERE titulo_enlace ='".$post_id."'");
		}else{ // Esta opcion solo se usa cuando enlaces_amigables esta activo,
			// Y intenta direccionar de una url por defecto, tipo art=30, en tal caso
			// valor de $redirect debe ser false
			$q = $objDataBase->Ejecutar("SELECT id FROM blog_posts WHERE id='".$post_id."'");
		}
	endif;
	if( G_ENL_AMIG == 0 ):
		$q = $objDataBase->Ejecutar("SELECT id FROM blog_posts WHERE id ='".$post_id."'");
	endif;

	$num_posts = $q->num_rows;
	if( $num_posts > 0):
		$Post = $q->fetch_assoc();
		$post_id = $Post['id'];
	else:
		return false;
	endif;

	if(G_ACCESOUSUARIO){
		$qa  = $objDataBase->Ejecutar("SELECT a.*, DATE_FORMAT(a.fecha_creacion, '%Y-%m-%d') as fecha_corta, DATE_FORMAT(a.fecha_creacion, '%d') as fecha_dia, DATE_FORMAT(a.fecha_creacion, '%M') as fecha_mes_l, DATE_FORMAT(a.fecha_creacion, '%m') as fecha_mes, DATE_FORMAT(a.fecha_creacion, '%Y') as fecha_anio
	  FROM blog_posts a WHERE id =".$post_id);
	}else{
		$qa  = $objDataBase->Ejecutar("SELECT a.*, DATE_FORMAT(a.fecha_creacion, '%Y-%m-%d') as fecha_corta, DATE_FORMAT(a.fecha_creacion, '%d') as fecha_dia, DATE_FORMAT(a.fecha_creacion, '%M') as fecha_mes_l, DATE_FORMAT(a.fecha_creacion, '%m') as fecha_mes, DATE_FORMAT(a.fecha_creacion, '%Y') as fecha_anio
	  FROM blog_posts a WHERE activo='A' AND id =".$post_id);
		if($qa->num_rows == 0){
			header('Location: '.G_SERVER.'404.php');
		}
	}
	// Como solo buscamos un unico valor y queremos usar la funcion "rb_return_post_array" que devuelve
	// un array asociativo, usamos el link de ayuda. Tanto para versiones nuevas como antiguas

	// http://librosweb.es/foro/pregunta/257/como-obtener-el-primer-elemento-de-un-array-php-asociativo/
	//  PHP (versión 5.4 o superior)
	return array_values( rb_return_post_array($qa) )[0];

	// PHP Versiones mas antiguas
	//return array_shift(array_values( rb_return_post_array($qa) ));
}

// Suma 1 unidad a cada acceso al post, paginas, etc
function rb_set_read_post($id, $table){
	global $objDataBase;
	$objDataBase->EditarPorCampo_int($table,'lecturas','lecturas+1',$id);
}

// Obtener 1 categoria del post segun id del post
function rb_get_category_by_post_id($post_id){
	global $objDataBase;
	$result = $objDataBase->Ejecutar("SELECT c.* FROM blog_categories c, blog_posts_categories ac, blog_posts a
  WHERE c.id=ac.categoria_id AND ac.articulo_id= a.id AND a.id =".$post_id." LIMIT 1");
	return $result;
}
// obtener info de categoria por id, o nombre_enlace

function rb_get_category_info($category){
	global $objDataBase;
	$qc  = $objDataBase->Ejecutar("SELECT * FROM blog_categories WHERE nombre_enlace='".$category."'");
	if(!$qc) return false;
	$num_reg = $qc->num_rows;
	if($num_reg==0):
		//Probamos con el Id
		$qc  = $objDataBase->Ejecutar("SELECT * FROM blog_categories WHERE id=$category");
		if(!$qc) return false;
	endif;
	$CategoriesArray = array();
	$i=0;
	while($Category = $qc->fetch_assoc()):
			$CategoriesArray['id'] = $Category['id'];
			$CategoriesArray['nombre'] = $Category['nombre'];
			$CategoriesArray['descripcion'] = $Category['descripcion'];
			$CategoriesArray['nombre_enlace'] = $Category['nombre_enlace'];
			$CategoriesArray['url'] = rb_url_link_blog( 'cat' , $Category['id'] );
			$CategoriesArray['photo_id'] = $Category['photo_id'];
		$i++;
	endwhile;
	return $CategoriesArray;
}

/* MUESTRA LASCCATEGORIAS DE POST EN PARTICULAR */
function rb_show_category_from_post($article_id){
  global $objDataBase;

	$q = $objDataBase->Ejecutar("SELECT c.* FROM blog_categories c, blog_posts_categories ac, blog_posts a
    WHERE c.id=ac.categoria_id AND ac.articulo_id= a.id AND a.id =".$article_id);

	$CategoriesArray = array();
	$i=0;
	while($Categories = $q->fetch_assoc()):
		$CategoriesArray[$i]['id'] = $Categories['id'];
		$CategoriesArray[$i]['nombre'] = $Categories['nombre'];
		$CategoriesArray[$i]['url'] = rb_url_link_blog( 'cat' , $Categories['id'] );
		$i++;
	endwhile;
	return $CategoriesArray;
}

function rb_nums_post_by_category($category_id){
  global $objDataBase;
	$q = $objDataBase->Ejecutar("SELECT c.articulo_id, a.* FROM blog_posts a, blog_posts_categories c
  WHERE a.id=c.articulo_id AND c.categoria_id=".$category_id." AND activo='A'");
	return $q->num_rows;
}

function rb_get_post_by_category($category_id="*", $num_posts=10, $regstart=0, $column="id", $ord = "DESC" ){ // Se cambio orden de parametros
	global $objDataBase;
	$rm_url = G_SERVER;
	$user_no_admin = "";
	if($category_id=="") return false;
	$limit = " LIMIT ".$regstart.", ".$num_posts;
	$datetime_fields = "DATE_FORMAT(a.fecha_creacion, '%Y-%m-%d') as fecha_corta,
	DATE_FORMAT(a.fecha_creacion, '%d') as fecha_dia, DATE_FORMAT(a.fecha_creacion, '%M') as fecha_mes_l, DATE_FORMAT(a.fecha_creacion, '%m') as fecha_mes,
	DATE_FORMAT(a.fecha_creacion, '%Y') as fecha_anio";

	// TODOS LOS POSTS
	if($category_id == "*"):
    if(G_ACCESOUSUARIO==0): // USUARIO FINAL, SOLO VISUALIZA PUBLICACIONES PUBLICAS
      $q_string = "SELECT c.acceso, c.niveles, a.*, $datetime_fields FROM blog_posts a, blog_posts_categories ac, blog_categories c
			WHERE a.id=ac.articulo_id AND ac.categoria_id = c.id AND a.activo='A' AND c.acceso = 'public'
			ORDER BY $column $ord $limit";
			$qa  = $objDataBase->Ejecutar($q_string);
    elseif(G_ACCESOUSUARIO==1): // USUARIO REGISTRADO
			// SI USUARIO NO ES ADMIN, SOLO VISUALIZA LO QUE TIENE ACCESO
			if(G_USERTYPE!="admin"){
				$user_no_admin = "AND c.niveles LIKE '%".G_USERNIVELID."%'";
			}
      $q_string = "SELECT c.acceso, c.niveles, a.*, $datetime_fields FROM blog_posts a, blog_posts_categories ac, blog_categories c
			WHERE a.id=ac.articulo_id AND ac.categoria_id = c.id AND a.activo='A' AND (c.acceso = 'public' OR c.acceso = 'privat' $user_no_admin)
			ORDER BY $column $ord $limit";
			$qa  = $objDataBase->Ejecutar($q_string);
		endif;

  // POST POR CATEGORIA
	elseif($category_id != "" || $category_id !=0 || $category_id != "*"):
		// BUSCA ID CATEGORIA POR NOMBRE-ENLACE
		$qc  = $objDataBase->Ejecutar("SELECT id FROM blog_categories WHERE nombre_enlace='".$category_id."'");
		if(!$qc) return false;
		$num_reg = $qc->num_rows;
		if($num_reg==0):
			// BUSCA ID CATEGORIA POR ID
			$qc  = $objDataBase->Ejecutar("SELECT id FROM blog_categories WHERE id=".$category_id);
			if(!$qc) return false;
			$num_reg = $qc->num_rows;
		endif;

		// SI HALLA ID CATEGORIA, PROCEDEMOS
		if($qc && $num_reg > 0 ):
			$ra = $qc->fetch_assoc();
			$category_id = $ra['id'];
      if(G_ACCESOUSUARIO==0): // USUARIO FINAL, SOLO VISUALIZA PUBLICACIONES PUBLICAS
        $q_string = "SELECT c.acceso, c.niveles, a.*, $datetime_fields FROM blog_posts a, blog_posts_categories ac, blog_categories c
  			WHERE a.id=ac.articulo_id AND ac.categoria_id = c.id AND a.activo='A' AND c.id=$category_id AND c.acceso = 'public'
  			ORDER BY $column $ord $limit";
  			$qa  = $objDataBase->Ejecutar($q_string);
  		elseif(G_ACCESOUSUARIO==1): // USUARIO REGISTRADO
				// SI USUARIO NO ES ADMIN, SOLO VISUALIZA LO QUE TIENE ACCESO
				if(G_USERTYPE!="admin"){
					$user_no_admin = "AND c.niveles LIKE '%".G_USERNIVELID."%'";
				}
        $q_string = "SELECT c.acceso, c.niveles, a.*, $datetime_fields FROM blog_posts a, blog_posts_categories ac, blog_categories c
  			WHERE a.id=ac.articulo_id AND ac.categoria_id = c.id AND a.activo='A' AND c.id=$category_id AND (c.acceso = 'public' OR c.acceso = 'privat' $user_no_admin)
  			ORDER BY $column $ord $limit";
  			$qa  = $objDataBase->Ejecutar($q_string);
      endif;
		else:
			return;
		endif;
	endif;

	return rb_return_post_array($qa);
}

// Muestra publicaciones destacadas
function rb_get_post_stars($post_max = 4){
	$q = $objDataBase->Ejecutar( "SELECT *, DATE_FORMAT(fecha_creacion, '%Y-%m-%d') as fecha_corta, DATE_FORMAT(fecha_creacion, '%d') as fecha_dia, DATE_FORMAT(fecha_creacion, '%M') as fecha_mes_l, DATE_FORMAT(fecha_creacion, '%m') as fecha_mes, DATE_FORMAT(fecha_creacion, '%Y') as fecha_anio
  FROM blog_posts WHERE portada=1 LIMIT $post_max" );
	return rb_return_post_array($q);
}

function rb_get_post_more_read($num_posts=10){
	//require_once( dirname( dirname(__FILE__) ) ."/global.php");
	$rm_url = G_SERVER;
	$qa  = $objDataBase->Ejecutar("SELECT a.*, DATE_FORMAT(a.fecha_creacion, '%Y-%m-%d') as fecha_corta, DATE_FORMAT(a.fecha_creacion, '%d') as fecha_dia, DATE_FORMAT(a.fecha_creacion, '%M') as fecha_mes_l, DATE_FORMAT(a.fecha_creacion, '%m') as fecha_mes, DATE_FORMAT(a.fecha_creacion, '%Y') as fecha_anio
  FROM blog_posts a WHERE activo='A' ORDER BY a.lecturas DESC LIMIT $num_posts");
	return rb_return_post_array($qa);
}

function rb_select_object_publication($nombre, $articulo_id, $tipo = 'image'){
	global $objDataBase;
	$result = $objDataBase->Ejecutar("SELECT contenido FROM blog_fields WHERE articulo_id=".$articulo_id." and tipo = '".$tipo."' and nombre = '".$nombre."' LIMIT 1");
	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		return $row['contenido'];
	}else{
		return false;
	}
}

function rb_show_half_post($content,$link) { // antes -> more_content
	$contArray=explode('<!--mas-->',$content);
	if(count($contArray)>1){
		$contArray[0] = preg_replace('/^[\s]*(.*)[\s]*$/','\\1',$contArray[0]);
		$enlace="<a href=\"".$link."\">Ver publicación completa</a>";
		return $contArray[0].$enlace;
	}else{
		return $content;
	}
}


/* Array de categorias y subcategorias
 * Parametros:
 * 		@$category_id -> id de la categoria que deseamos buscar su ancestros.
 *    @path -> variable interna para almacenar la ruta consultada de momento
 * */
function rb_categories_to_array($category_id, $all=true) {
	global $objDataBase;
  	$q = "SELECT c.categoria_id, c.nivel, c.id, c.nombre, c.acceso, c.niveles, Items.Count FROM blog_categories c LEFT OUTER JOIN (SELECT categoria_id, COUNT(*) AS Count FROM blog_categories GROUP BY categoria_id) Items ON c.id = Items.categoria_id WHERE c.categoria_id=$category_id ORDER BY id";
	//$r = mysql_query($q);
	$r = $objDataBase->Ejecutar( $q );
	while ( $row = $r.fetch_assoc() ):
		$i = $row['id'];
    // Si el acceso es privado, no se mostrara, pero antes
    // se comparara el nivel del usuario con el de la categoria
    if($row['acceso']=="privat"):
      if(G_USERNIVELID>0){
        $pos = strpos($row['niveles'], G_USERNIVELID);
        if($pos === FALSE) continue;
      }else{
        continue;
      }
    endif;
		if ($row['Count'] > 0):
			$categories[$i]['id'] = $row['id'];
			$categories[$i]['categoria_id'] = $row['categoria_id'];
			$categories[$i]['nivel'] = $row['nivel'];
			$categories[$i]['nombre'] = $row['nombre'];
      		$categories[$i]['acceso'] = $row['acceso'];
      		$categories[$i]['niveles'] = $row['niveles'];
      		$categories[$i]['url'] = rb_url_link_blog( 'cat' , $row['id'] );
			$categories[$i]['items'] = rb_categories_to_array($row['id']);
		elseif($row['Count']==0):
			$categories[$i]['id'] = $row['id'];
			$categories[$i]['categoria_id'] = $row['categoria_id'];
			$categories[$i]['nivel'] = $row['nivel'];
			$categories[$i]['nombre'] = $row['nombre'];
      		$categories[$i]['acceso'] = $row['acceso'];
      		$categories[$i]['niveles'] = $row['niveles'];
      		$categories[$i]['url'] = rb_url_link_blog( 'cat' , $row['id'] );
		endif;
	endwhile;

	return $categories;
}

function rb_url_link_blog($section, $id, $page=0){
  global $objDataBase;
	$base_pub = blog_get_option("base_publication");
	$base_cat = blog_get_option("base_category");
	$url_web = G_SERVER;
	$link_friendly = G_ENL_AMIG;
	switch($section){
		case "cat":
			if($link_friendly){
				$q = $objDataBase->Ejecutar("SELECT id FROM blog_categories WHERE id='$id'"); //verificar mas adelante 26/08/17 id x nombre_enlace
				if( $q->num_rows==0 ):
					return $url_web;
				endif;
				$r = $q->fetch_assoc();
				$q = $objDataBase->Ejecutar("SELECT nombre_enlace FROM blog_categories WHERE id=".$r['id']);

				$r = $q->fetch_assoc();
				$name_link = $r['nombre_enlace'];
				if($page==0 || $page==1) return $url_web.$base_cat."/".$name_link."/";
				else return $url_web.$base_cat."/".$name_link."/".G_BASEPAGE."/".$page."/";
			}else{
				if($page==0 || $page==1) return $url_web."?cat=".$id;
				else return $url_web."?cat=".$id."&page=".$page;
			}
			break;
		case "art":
		case "post":
			if($link_friendly){
				$q = $objDataBase->Ejecutar("SELECT titulo_enlace FROM blog_posts WHERE id=".$id);
				$r = $q->fetch_assoc();
				$name_link = $r['titulo_enlace'];
				return $url_web.$base_pub."/".$name_link."/";
			}else{
				return $url_web."?art=".$id;
			}
			break;
	}
}

// LISTADO DE CATEGORIAS, PARA EL EDITOR DE PUBLICACION
function blog_list_category($parent_id){
	global $objDataBase;

	$array_main = [];

	$result = $objDataBase->Ejecutar("SELECT c.id, c.nombre, c.nombre_enlace, c.descripcion, c.photo_id, SubTable.Count FROM `blog_categories` c
    LEFT OUTER JOIN (SELECT categoria_id, COUNT(*) AS Count FROM `blog_categories` GROUP BY categoria_id) SubTable ON c.id = SubTable.categoria_id
    WHERE c.categoria_id=". $parent_id);

	while ($row = $result->fetch_assoc()):
		if ($row['Count'] > 0) {
			$array = [
				'id' => $row['id'],
				'nombre' => $row['nombre'],
				'nombre_enlace' => $row['nombre_enlace'],
				'descripcion' => $row['descripcion'],
				'foto_id' => $row['photo_id'],
				'url' => rb_url_link_blog( 'cat' , $row['id'] ),
				'items' => blog_list_category( $row['id'] )
			];
		}elseif ($row['Count']==0) {
			$array = [
				'id' => $row['id'],
				'nombre' => $row['nombre'],
				'nombre_enlace' => $row['nombre_enlace'],
				'descripcion' => $row['descripcion'],
				'foto_id' => $row['photo_id'],
				'url' => rb_url_link_blog( 'cat' , $row['id'] )
			];

		}
		array_push($array_main, $array);
	endwhile;

	return $array_main;
}
?>
