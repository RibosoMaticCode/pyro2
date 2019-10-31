<?php
header('Content-type: application/json; charset=utf-8');

require_once '../global.php';
require_once 'funcs.php';
if(G_ACCESOUSUARIO>0){
  $response = rb_backup_data();
  if($response['response']){
    $arr = ['resultado' => true, 'contenido' => 'Copia de BD generada', 'filename' => $response['filename'], 'url_backup' => $response['url_backup']];
  }else{
    $arr = ['resultado' => false, 'contenido' => 'Ocurrio un error durante el proceso, vuelva a intentarlo.'];
  }
}else{
  $arr = ['resultado' => false, 'contenido' => 'No cuenta con los permisos'];
}

die(json_encode($arr));
?>
