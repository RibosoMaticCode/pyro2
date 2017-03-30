<?php 
include_once("rb-conexion.class.php");

class Articulos{
	//constructor	
 	var $con;
 	function Articulos(){
 		$this->con=new Conector;
 	}
	
	// metodos basicos
	function Insertar($campos){
		if($this->con->conectar()){
			return mysql_query("INSERT INTO articulos (fecha_creacion, titulo, titulo_enlace, autor_id, tags, contenido, portada, img_portada, actividad, fecha_actividad, video, video_embed, galeria_id) VALUES ( NOW() ,'".$campos[0]."','".$campos[1]."',".$campos[2].",'".$campos[3]."','".$campos[4]."',".$campos[5].",'".$campos[6]."',".$campos[7].",'".$campos[8]."',".$campos[9].",'".$campos[10]."',".$campos[11].")");
		}
	}
	
	function Editar($campos, $id){
		if($this->con->conectar($campos, $id)){
			return mysql_query("UPDATE articulos SET titulo='".$campos[0]."', titulo_enlace='".$campos[1]."', tags='".$campos[2]."', contenido='".$campos[3]."', portada=".$campos[4].", img_portada='".$campos[5]."', actividad=".$campos[6].", fecha_actividad='".$campos[7]."', fecha_creacion='".$campos[8]."', video=".$campos[9].", video_embed = '".$campos[10]."', galeria_id = ".$campos[11]." WHERE id=".$id);
		}
	}
	
	function Eliminar($id){
		if($this->con->conectar()){
			mysql_query("DELETE FROM articulos_categorias WHERE articulo_id=$id");
			mysql_query("DELETE FROM objetos WHERE articulo_id=$id");
			mysql_query("DELETE FROM articulos WHERE id=$id");
			mysql_query("DELETE FROM comentarios WHERE articulo_id=$id");
			return;
		}
	}
	
	function Consultar($q){
		if($this->con->conectar()){
			return mysql_query($q);
		}
	}
	
	// metodos adicionales
	function EditarPorCampo($campo,$valor,$id){ // string
    	if($this->con->conectar()==true){
			// incluir scapes a comillas simples
     		return mysql_query("UPDATE articulos SET $campo='$valor' WHERE id=$id");
		}
	}
	
	function EditarPorCampo_int($campo,$valor,$id){ // int
    	if($this->con->conectar()==true){
			// incluir scapes a comillas simples
     		return mysql_query("UPDATE articulos SET $campo=$valor WHERE id=$id");
		}
	}

    function Search($term, $limit=false, $toStart=0, $toShow=0){
        if($this->con->conectar()){
            if($limit){
                $result = mysql_query("SELECT DATE_FORMAT(a.fecha_creacion, '%Y-%m-%d') as fecha_corta, a.id, a.fecha_creacion, a.titulo, a.titulo_enlace, a.contenido, a.lecturas, a.comentarios, a.img_portada, a.activo, a.actcom, a.autor_id, u.nickname, u.nombres, MATCH ( a.titulo, a.contenido ) AGAINST ( '$term' ) AS score FROM articulos a, usuarios u WHERE a.autor_id = u.id  AND MATCH ( a.titulo, a.contenido ) AGAINST ( '$term' ) ORDER BY score DESC LIMIT $toStart, $toShow");
            }else{
                $result = mysql_query("SELECT DATE_FORMAT(a.fecha_creacion, '%Y-%m-%d') as fecha_corta, a.id, a.fecha_creacion, a.titulo, a.titulo_enlace, a.contenido, a.lecturas, a.comentarios, a.img_portada, a.activo, a.actcom, a.autor_id, u.nickname, u.nombres, MATCH ( a.titulo, a.contenido ) AGAINST ( '$term' ) AS score FROM articulos a, usuarios u WHERE a.autor_id = u.id  AND MATCH ( a.titulo, a.contenido ) AGAINST ( '$term' ) ORDER BY score DESC");
            }
            return $result;
        }
    }

	/* SELECCIONA UN OBJETO EN PARTICULAR DE LA PUBLICACION */
	function SelectObject($nombre, $articulo_id, $tipo = 'image'){
		$result = mysql_query("SELECT contenido FROM objetos WHERE articulo_id=".$articulo_id." and tipo = '".$tipo."' and nombre = '".$nombre."' LIMIT 1");
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			return $row['contenido'];	
		}else{
			return false;
		}
	}
	
	/* SELECCIONA UN ALBUM EN PARTICULAR DE LA PUBLICACION */
	function SelectIdAlbum($articulo_id){
		$result = mysql_query("SELECT b.nombre, b.id FROM articulos a, albums b, articulos_albums ab WHERE a.id=ab.articulo_id AND ab.album_id = b.id AND a.id =".$articulo_id." LIMIT 1");
		$row = mysql_fetch_array($result);
		return $row['id'];
	}
    	
	function Relacionados($tags, $limit = 3){
		$trozos=explode(" ",$tags);
		$numero=count($trozos);
		if ($numero==1){
			$result=@mysql_query("SELECT * FROM articulos WHERE activo='A' AND CONTENIDO LIKE '%$tags%' OR TITULO LIKE '%$tags%' ORDER BY fecha_creacion DESC LIMIT $limit;");
		}elseif($numero>1){
			$result=@mysql_query("SELECT * , MATCH ( TITULO, CONTENIDO ) AGAINST ( '$tags' ) AS Score FROM articulos WHERE activo='A' AND MATCH ( TITULO, CONTENIDO ) AGAINST ( '$tags' ) ORDER BY score, fecha_creacion ASC LIMIT $limit;");
		}
		return $result;
	}
}
$objArticulo = new Articulos;
?>