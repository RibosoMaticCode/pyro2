<?php 
include_once("rb-conexion.class.php");

class Paginas{
	//constructor	
 	var $con;
 	function Paginas(){
 		$this->con=new Conector;
 	}
	
	// metodos basicos
	function Insertar($campos){
		if($this->con->conectar()){
		    
			return mysql_query("INSERT INTO paginas (fecha_creacion, titulo, titulo_enlace, autor_id, tags, contenido, sidebar, popup, galeria_id, addon) VALUES ( NOW() ,'".$campos[0]."','".$campos[1]."',".$campos[2].",'".$campos[3]."','".$campos[4]."',".$campos[5].",".$campos[6].",".$campos[7].",'".$campos[8]."')");               
		}
	}
	
	function Editar($campos, $id){
		if($this->con->conectar($campos, $id)){
			return mysql_query("UPDATE paginas SET titulo='".$campos[0]."', titulo_enlace='".$campos[1]."', autor_id=".$campos[2].", tags='".$campos[3]."', contenido='".$campos[4]."', sidebar=".$campos[5].", popup = ".$campos[6].", galeria_id = ".$campos[7].", addon = '".$campos[8]."'  WHERE id=".$id);
		}
	}
	
	function Eliminar($id){
		if($this->con->conectar()){
			return mysql_query("DELETE FROM paginas WHERE id=$id");
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
     		return mysql_query("UPDATE paginas SET $campo='$valor' WHERE id=$id");
		}
	}
	
	function EditarPorCampo_int($campo,$valor,$id){ // int
    	if($this->con->conectar()==true){
			// incluir scapes a comillas simples
     		return mysql_query("UPDATE paginas SET $campo=$valor WHERE id=$id");
		}
	}

    function Search($term, $limit=false, $toStart=0, $toShow=0){
        if($this->con->conectar()){
            if($limit){
                $result = mysql_query("SELECT DATE_FORMAT(a.fecha_creacion, '%Y-%m-%d') as fecha_corta, a.id, a.fecha_creacion, a.titulo, a.contenido, a.titulo_enlace, a.autor_id, u.nickname, u.nombres, MATCH ( a.titulo, a.contenido ) AGAINST ( '$term' ) AS score FROM paginas a, usuarios u WHERE a.autor_id = u.id AND popup = 0 AND MATCH ( a.titulo, a.contenido ) AGAINST ( '$term' ) ORDER BY score DESC LIMIT $toStart, $toShow");
            }else{
                $result = mysql_query("SELECT DATE_FORMAT(a.fecha_creacion, '%Y-%m-%d') as fecha_corta, a.id, a.fecha_creacion, a.titulo, a.contenido, a.titulo_enlace, a.autor_id, u.nickname, u.nombres, MATCH ( a.titulo, a.contenido ) AGAINST ( '$term' ) AS score FROM paginas a, usuarios u WHERE a.autor_id = u.id AND popup = 0 AND MATCH ( a.titulo, a.contenido ) AGAINST ( '$term' ) ORDER BY score DESC");
            }
            
            return $result;
        }
    }
    /*	
	function Relacionados($tags, $limit = 3){
		$trozos=explode(" ",$tags);
		$numero=count($trozos);
		if ($numero==1){
			$result=@mysql_query("SELECT * FROM articulos WHERE activo='A' AND CONTENIDO LIKE '%$tags%' OR TITULO LIKE '%$tags%' ORDER BY fecha_creacion DESC LIMIT $limit;");
		}elseif($numero>1){
			$result=@mysql_query("SELECT * , MATCH ( TITULO, CONTENIDO ) AGAINST ( '$tags' ) AS Score FROM articulos WHERE activo='A' AND MATCH ( TITULO, CONTENIDO ) AGAINST ( '$tags' ) ORDER BY score, fecha_creacion ASC LIMIT $limit;");
		}
		return $result;
	}*/
}
$objPagina = new Paginas;
?>
