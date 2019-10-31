<?php
function list_file($carpeta){
  if(is_dir($carpeta)){
    if($dir = opendir($carpeta)){
      while(($archivo = readdir($dir)) !== false){
        if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
          if(is_dir($archivo)){
            $tipo = "dir";
          }else{
            $tipo = "file";
          }
          echo '<li><a data-type="'.$tipo.'" class="filename" target="_blank" href="'.$carpeta.$archivo.'">'.$archivo.'['.$tipo.']</a></li>';
        }
      }
      closedir($dir);
    }
  }
}
if(isset($_GET['dir'])):
	echo "<li>Regresar</li>";
	list_file($_GET['dir']."/");
else:
	list_file($dir_style);
endif;
?>