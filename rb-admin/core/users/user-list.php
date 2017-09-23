<?php
//require_once(ABSPATH."rb-script/class/rb-usuarios.class.php");
$regMostrar = $_COOKIE['user_show_items'];

$colOrder = "nickname"; // column name table
$Ord = "ASC"; // A-Z

if(isset($_GET['page']) && ($_GET['page']>0)){
  $RegistrosAEmpezar=($_GET['page']-1)*$regMostrar;
}else{
  $RegistrosAEmpezar=0;
}

function show_nivel($nivel_id){
  global $objDataBase;
  $q = $objDataBase->Ejecutar("SELECT nombre FROM usuarios_niveles WHERE id=$nivel_id");
  $r = $q->fetch_assoc();
  if( $q->num_rows > 0 )
    return $r['nombre'];
  else
    return "Ninguno";
}

$result = $objDataBase->Ejecutar("SELECT * FROM usuarios ORDER BY $colOrder $Ord LIMIT $RegistrosAEmpezar, $regMostrar");
while ( $row = $result->fetch_assoc() ){
  echo '	<tr>
        <td><input id="user-'.$row['id'].'" type="checkbox" value="'.$row['id'].'" name="items" /></td>
        <td>'.$row['nickname'].'</td>
        <td>'.$row['nombres'].' '.$row['apellidos'].'
        <div class="options">
        <span><a title="Editar" href="../rb-admin/index.php?pag=usu&amp;opc=edt&amp;id='.$row['id'].'">Editar</a></span>
        <span><a style="color:red" href="#" title="Eliminar" onclick="Delete('.$row['id'].',\'usu\')">Eliminar</a></span></td>
        </div>
        </td>
        <td>'.$row['correo'].'</td>
        <td>'.show_nivel($row['tipo']).'</td>';
  echo		'<td>';
        if($row['activo']==0) echo '<a href="user.active.php?id='.$row['id'].'">¿Activar?</a>';
        else echo "Activo";
  echo 		'</td>';
}
?>
