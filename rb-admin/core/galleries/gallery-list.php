<?php
//require_once(ABSPATH."rb-script/class/rb-galerias.class.php");

if(G_USERTYPE == "admin"):
  $q = $objDataBase->Ejecutar("SELECT a . * , (
          SELECT COUNT( id )
          FROM photo
          WHERE album_id = a.id
          ) AS nrophotos
          FROM  `albums` a");
else:
  $q = $objDataBase->Ejecutar("SELECT a . * , (
          SELECT COUNT( id )
          FROM photo
          WHERE album_id = a.id
          ) AS nrophotos
          FROM  `albums` a WHERE usuario_id =".G_USERID);
endif;
while ($row = $q->fetch_assoc()){

  echo "<tr>
      <td><input id=\"art-".$row['id']."\" type=\"checkbox\" value=\"".$row['id']."\" name=\"items\" /></td>
      <!--<td width='40px;'>
      <span>
        <a title=\"Agregar fotos al album\" href='../rb-admin/index.php?pag=img&amp;opc=nvo&amp;album_id=".$row['id']."'>
        <img style=\"border:0px;\" width=\"16px\" height=\"16px\" src=\"img/add.png\" alt=\"Agregar Fotos\" /></a>
      </span>
      </td>-->
      <td>
        <h3>".$row['nombre']."</h3>
        <div class='options'>
          <span><a href='../rb-admin/index.php?pag=img&amp;album_id=".$row['id']."'>Ver contenido</a></span>
          <span><a href='../rb-admin/index.php?pag=gal&amp;opc=edt&amp;id=".$row['id']."'>Editar</a></span>
          <span><a href='#' style=\"color:red\" onclick=\"Delete(".$row['id'].",'gal')\">Eliminar</a></span>
        </div>
      </td>
      <td>".$row['descripcion']."</td>
      <td>".$row['fecha']."</td>
      <td>".$row['nrophotos']."</td>
    <tr>";
}
?>
