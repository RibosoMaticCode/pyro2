<?php
// Navega entre el directorio especificado en la variable $carpeta
// Crear y retorna un array ordenado
function list_file($carpeta){
  $dir_list = [];
  if(is_dir($carpeta)){
    if($dir = opendir($carpeta)){
      while(($archivo = readdir($dir)) !== false){
        if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
          if(is_dir($archivo)){
            $tipo = "dir";
            $tipo_icon = '<i class="fas fa-folder"></i>';
          }else{
            $tipo = "file";
            $tipo_icon = '<i class="far fa-file-alt"></i>';
          }
          $new_item_list = [
            'tipo' => $tipo,
            'icon' => $tipo_icon,
            'ref' => $carpeta.$archivo,
            'file_name' => $archivo
          ];
          array_push($dir_list, $new_item_list);
        }
      }
      closedir($dir);
      usort($dir_list, 'sort_by_orden');
      return $dir_list;
    }
  }
}

// Funcion para ordenar el array multidimensional
function sort_by_orden ($a, $b) {
    return $a['tipo'] <=> $b['tipo'];
}

// Array a mostrar en formato de lista
$list_files = [];
if(isset($_GET['dir'])):
	print "<li>Regresar</li>";
	$list_files = list_file($_GET['dir']."/");
else:
  $list_files = list_file($dir_style);
endif;

foreach ($list_files as $file) {
  print '<li><a data-type="'.$file['tipo'].'" class="filename" target="_blank" href="'.$file['ref'].'">'.$file['icon'].' '.$file['file_name'].'</a></li>';
}
?>
