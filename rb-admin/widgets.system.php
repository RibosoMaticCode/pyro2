<?php
// DECLRARA WIDGET DEL SISTEMA AQUI:

// Datos de este widget
$widget = [
  'link_action' => 'addHtmlRaw',
  'dir' => 'code',
  'name' => 'Código',
  'desc' => 'Editor de código HTML',
  'filejs' => 'file.js',
  'img' => 'browser.png',
  'file' => 'w.code.php',
  'type' => 'htmlraw'
];
//Añadiendo al array principals widgets
array_push($widgets, $widget);

// Datos de este widget
$widget = [
  'link_action' => 'addHtml',
  'dir' => 'editor',
  'name' => 'Editor',
  'desc' => 'Editor de texto WYSIWYG para HTML',
  'filejs' => 'file.js',
  'img' => 'editor.png',
  'file' => 'w.editor.php',
  'type' => 'html'
];
//Añadiendo al array principals widgets
array_push($widgets, $widget);

// Datos de este widget
$widget = [
  'link_action' => 'addGalleries',
  'dir' => 'gallery',
  'name' => 'Galerias',
  'desc' => 'Muestra diferentes galerias del sistema',
  'filejs' => 'file.js',
  'img' => 'galleries.png',
  'file' => 'w.gallery.php',
  'type' => 'galleries'
];
//Añadiendo al array principals widgets
array_push($widgets, $widget);

// Datos de este widget
/*$widget = [
  'link_action' => 'addPost1',
  'dir' => 'pubs',
  'name' => 'Publicaciones',
  'desc' => 'Muestra un listado de publicaciones',
  'filejs' => 'file.js',
  'img' => 'pubs.png',
  'file' => 'w.pubs.php',
  'type' => 'post1'
];
//Añadiendo al array principals widgets
array_push($widgets, $widget);*/

// Datos de este widget
$widget = [
  'link_action' => 'addSidebar',
  'dir' => 'sidebar',
  'name' => 'Barra lateral',
  'desc' => 'Configurar la barra lateral',
  'filejs' => 'file.js',
  'img' => 'sidebar.png',
  'file' => 'w.sidebar.php',
  'type' => 'sidebar'
];
//Añadiendo al array principals widgets
array_push($widgets, $widget);

// Datos de este widget
$widget = [
  'link_action' => 'addSlide',
  'dir' => 'slide',
  'name' => 'Galeria',
  'desc' => 'Añade una galeria de imagenes',
  'filejs' => 'w.slide.js',
  'img' => 'gallery.png',
  'file' => 'w.slide.php',
  'type' => 'slide'
];
//Añadiendo al array principals widgets
array_push($widgets, $widget);

// Datos de este widget
$widget = [
  'link_action' => 'addYoutube1',
  'dir' => 'youtube',
  'name' => 'Video de Youtube',
  'desc' => 'Lista de reprodución de Youtube',
  'filejs' => 'file.js',
  'img' => 'youtube.png',
  'file' => 'w.youtube.php',
  'type' => 'youtube1'
];
//Añadiendo al array principals widgets
array_push($widgets, $widget);
?>
