<?php
include 'islogged.php';
$obj = json_decode($_GET['mydata'], true);

// consultar array del menu
print_r($obj);

// recorrer $obj
foreach ($obj as $key => $value) {
  echo $value['name']."<br />"; // buscar en array de menupanel
  echo $value['position']."<br />"; // reemplzar con este valor
}
?>
