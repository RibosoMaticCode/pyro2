<?php
/*
 * Hook - Gancho cacero 1.0 (Jesus Liñán)
 * 
 * Referencias:
 * 
 * http://abhinavsingh.com/how-to-add-wordpress-like-add_filter-hooks-in-your-php-framework/
 * http://stackoverflow.com/questions/42/best-way-to-allow-plugins-for-a-php-application?rq=1 
 * 
 */	

 //$hooks['the_head'] = array(); //array que contendra nombre de funciones
 //$hooks['the_content'] = array(); ///array que contendra nombre de funciones

 function add_function($on, $func, $pos=0) { // Añade funcion a un array que especifica la ubicacion en el codigo de la plantilla
   	global $hooks;
   	if($pos>0):
		$hooks[$on][$func]['name'] = $func;
		$hooks[$on][$func]['pos'] = $pos;
	elseif($pos==0):
   		$hooks[$on][$func]['name'] = $func;
		$hooks[$on][$func]['pos'] = 10;
	endif;
}
  
function do_action($ubicacion){ // De acuerdo a la ubicacion añade las funciones y las EJECUTA
	global $hooks; // Array
	if(!isset($content)) $content=""; 
 	 	
	if(!isset($hooks[$ubicacion])){
		echo "<!-- no hay funciones en esta ubicacion -->"; 
		return;
	}
		
 	$list_func = array();
	// Obtenemos lista de funciones de $ubicacion
	foreach ($hooks[$ubicacion] as $clave => $valor) {
	    $list_func[] = array('funcion' => $clave, 'orden' => $valor['pos']);
	}
	// rearmamos el array
	foreach ($list_func as $clave => $fila) {
	    $funcion[$clave] = $fila['funcion'];
	    $orden[$clave] = $fila['orden'];
	}
	// ordenamos
	array_multisort($orden, SORT_ASC, $list_func);
	// volvemos a listar
	
  	foreach($list_func as $hook) {
    	$content .= call_user_func($hook['funcion'], $content);
		//$content .= $hook['funcion'];
  	}
  	
 	echo $content;
}
?>