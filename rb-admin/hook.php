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

//$hooks['the_head'] = array(); //array que contendra nombre de funciones -- no usados -- solo pruebas
//$hooks['the_content'] = array(); ///array que contendra nombre de funciones -- no usados -- solo pruebas

// hook.php, es el primer archivo que se referencia cuando se inicial el gestor de contenidos y/o sitio web

// $hooks, es un array de ambito global

// add_function(), añade Funciones a un Array Principal Global, tambien su ubicacion (entero) por defecto 0
// $on -> ubicacion o seccion de la web que invocará la(s) funcion(es),
// $func -> cualquier funcion sin parametros de entrada
// $pos -> posicion de ejecucion, si establecemos 1 por ejemplo, se ejecutara antes que las demas, se le dara prioridad

// Ej de uso: Queremos mostrar un "hola mundo" en la pantalla inicial (con el valor: pantalla_inicial),
// entonces declaramos una funcion hola_mundo(), que retornara la cadena "hola mundo"
// Entonces agregamos la funcion asi: add_function( 'pantalla_inicial', 'hola_mundo');

function add_function($on, $func, $pos=0) {
  global $hooks;
  if($pos>0):
    $hooks[$on][$func]['name'] = $func;
    $hooks[$on][$func]['pos'] = $pos;
  elseif($pos==0):
    $hooks[$on][$func]['name'] = $func;
    $hooks[$on][$func]['pos'] = 10;
  endif;
}

// do_action(), llamara a las funciones segun el parametro: ubicacion o seccion
// $ubicacion -> ubicacion o seccion

// Ej de uso: Si en la pantalla inicial, hay un llamado: do_action('pantalla_inicial'), se ejecutaran las funciones que
// se hagan referencia a: add_function ('pantalla_inicial', funciones a ejecutar)
// del ejemplo anterior

function do_action($ubicacion){ // De acuerdo a la ubicacion añade las funciones y las EJECUTA
	global $hooks; // Array global
	if(!isset($content)) $content=""; // ????? Si no hay contenido, no mostramos nada

	if(!isset($hooks[$ubicacion])){
		echo "<!-- no hay funciones en esta ubicacion -->";
		return;
	}

 	$list_func = array(); // lista de funciones

	// Obtenemos lista de funciones de esta ubicacion
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

  // Recorremos la lista de funciones, y vamos haciendo una sumatoria de su contenido, el cual retornaremos como cadena
  foreach($list_func as $hook) {
  	$content .= call_user_func($hook['funcion']); // Antes segundo parametro era: $content
		//$content .= $hook['funcion'];
  }

 	return $content; // Antes echo - investigar el problema
}
?>
