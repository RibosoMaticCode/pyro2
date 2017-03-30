<?php
include_once("rb-conexion.class.php");

class Categorias{
	//constructor
	var $con;
	function Categorias(){
 		$this->con=new Conector;
	}
	function Consultar($q){
		if($this->con->conectar()){
			return mysql_query($q);
		}
	}
	function Insertar($campos){
		if($this->con->conectar()){
			return mysql_query("INSERT INTO categorias (nombre_enlace, nombre, descripcion, categoria_id, nivel, photo_id) VALUES ('".$campos[0]."','".$campos[1]."','".$campos[2]."',".$campos[3].",".$campos[4].", $campos[5] )");
		}
	}

	function Editar($campos, $id){
		if($this->con->conectar($campos, $id)){
			return mysql_query("UPDATE categorias SET nombre_enlace='".$campos[0]."', nombre='".$campos[1]."', descripcion='".$campos[2]."', categoria_id=".$campos[3].", nivel=".$campos[4].", photo_id = ".$campos[5]." WHERE id=".$id);
		}
	}

	function Eliminar($id){
		if($this->con->conectar()){
			return mysql_query("DELETE FROM categorias WHERE id=$id");
		}
	}
	// metodos adicionales
	function categorias_del_articulo($articulo_id){
		if($this->con->conectar()==true){
			return mysql_query("SELECT c.* FROM categorias c, articulos_categorias a WHERE a.categoria_id=c.id AND a.articulo_id=$articulo_id");
   		}
	}

	function EliminarNodos($categoria_id){
		if($this->con->conectar()==true){

		    $r = mysql_query("SELECT a.id, a.nombre, subcat.Count FROM categorias a  LEFT OUTER JOIN (SELECT categoria_id, COUNT(*) AS Count FROM categorias GROUP BY categoria_id) subcat ON a.id = subcat.categoria_id WHERE a.categoria_id=" . $categoria_id);

		    while ($row = mysql_fetch_assoc($r)) {
		        if ($row['Count'] > 0) {
		            //echo $row['id'].$row['nombre']."<br>";
		            $this->EliminarNodos($row['id']);
					//echo "eliminar id=".$row['id']."<br>";
					return mysql_query("DELETE FROM categorias WHERE id=".$row['id']);
		        } elseif ($row['Count']==0) {
		            //echo $row['id'].$row['nombre']."<br>";
		            //echo "eliminar id=".$row['id']."<br>";
					return mysql_query("DELETE FROM categorias WHERE id=".$row['id']);
		        } else;
		    }
   		}
	}
}
$objCategoria = new Categorias;
?>
