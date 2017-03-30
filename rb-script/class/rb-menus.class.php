<?php
include_once("rb-conexion.class.php");

class Menus{
	//constructor	
	var $con;
	function Menus(){
 		$this->con=new Conector;
	}
	function Consultar($q){
		if($this->con->conectar()){
			return mysql_query($q);
		}
	}
	function Insertar($campos){
		if($this->con->conectar()){
			return mysql_query("INSERT INTO menus_items (nombre_enlace, nombre, url, menu_id, nivel, mainmenu_id, tipo, style) VALUES ('".$campos[0]."','".$campos[1]."','".$campos[2]."',".$campos[3].",".$campos[4].", ".$campos[5].", '".$campos[6]."', '".$campos[7]."')");
		}
	}
	
	function Editar($campos, $id){
		if($this->con->conectar($campos, $id)){
			return mysql_query("UPDATE menus_items SET nombre_enlace='".$campos[0]."', nombre='".$campos[1]."', url='".$campos[2]."', menu_id=".$campos[3].", nivel=".$campos[4].", tipo = '".$campos[5]."', style = '".$campos[6]."' WHERE id=".$id);
		}
	}
	
	function Eliminar($id){
		if($this->con->conectar()){
			return mysql_query("DELETE FROM menus WHERE id=$id");
		}
	}
	// metodos adicionales
	
	// --> Eliminar nodo especifico 
	function Eliminar_Item($id){
		if($this->con->conectar()){
			return mysql_query("DELETE FROM menus_items WHERE id=$id");
		}
	}
	
	// --> Eliminar sub menus de un menu
	function EliminarNodos($menu_id){
		if($this->con->conectar()==true){
			return mysql_query("DELETE FROM menus_items WHERE mainmenu_id=$menu_id");
		}
	}
    /*function EliminarNodos($menu_id){
        if($this->con->conectar()==true){
            
            $r = mysql_query("SELECT a.id, a.nombre, submenu.Count FROM menus_items a  LEFT OUTER JOIN (SELECT menu_id, COUNT(*) AS Count FROM menus_items GROUP BY menu_id) submenu ON a.id = submenu.menu_id WHERE a.menu_id=" . $menu_id);

            while ($row = mysql_fetch_assoc($r)) {
                if ($row['Count'] > 0) {
                    $this->EliminarNodos($row['id']);
                    return mysql_query("DELETE FROM menus_items WHERE id=".$row['id']);                  
                } elseif ($row['Count']==0) {
                    return mysql_query("DELETE FROM menus_items WHERE id=".$row['id']);
                } else;
            }
        }       
    }*/
}
$objMenu = new Menus;
?>