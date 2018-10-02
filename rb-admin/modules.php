<?php
require_once 'hook.php';
require_once 'admin.php';
include 'islogged.php';

// Carga formato js de la base de datos
global $objOpcion;
$modules_prev = rb_get_values_options('modules_load');

// Convierte json a array
$array_modules = json_decode($modules_prev, true);

// Incluir los modulos de la base de datos
require_once 'modules.list.php';

$rb_title_module = "Listado de modulos";
$rb_title = $rb_title_module." | ".G_TITULO;

include_once 'header.php';
$seccion = 'modules-list'; // pintar boton del menu
?>
<section id="wrap">
	<?php include('menu.php') ?>
	<div id="message"></div>
	<div id="contenedor">
		<h2 class="title"><?= $rb_title_module ?></h2>
		<div class="page-bar">Modulos</div>
		<?php
		function listado_modulos(){
			global $array_help_close;
			if(isset($_GET['opc'])):
				$opc=$_GET['opc'];
			else:
				?>
				<?php if (!in_array("module", $array_help_close)): ?>
				<div class="help" data-name="module">
		       <h4>Información</h4>
		       <p>Los <strong>módulos</strong> proporciona funcionamientos adicionales al gestor. Aqui podrá activar ó desactivar módulos para el Gestor. Los archivos de código de los módulos, se almacenan en: <code>/rb-script/modules/modulo-nombre</code>.</p>
				</div>
				<?php endif ?>
				<div class="wrap-content-list">
					<section class="seccion">
						<table class="tables">
							<thead>
								<tr>
									<th style="width:30px"><input type="checkbox" value="all" id="select_all" /></th>
									<th>Módulo</th>
									<th>Descripcion</th>
								</tr>
							</thead>
							<tbody>
								<?php
								// Leer comentarios con datos e informacion de cabecera de modulos/plugins
								// Creditos: http://stackoverflow.com/questions/24099741/reading-commented-details-in-a-file-like-wordpress-theme-engine
								function get_file_data( $file, $default_headers) {

								    $fp = fopen( $file, 'rb');
								    $file_data = fread( $fp, 8192 );
								    //$file_data = fread( $fp, filesize($file) );
								    fclose( $fp );
								    $file_data = str_replace( "\r", "\n", $file_data );
								    $all_headers = $default_headers;

								    foreach ( $all_headers as $field => $regex ) {
								        if (preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1]):
								            $all_headers[ $field ] = trim(preg_replace("/\s*(?:\*\/|\?>).*/", '', $match[1]));
								        else:
								            //$all_headers[ $field ] = '';
								            unset($all_headers[ $field ]);
										endif;
								    }
								    return $all_headers;
								}

								// Carpeta a explorar
								$carpeta = $_SERVER['DOCUMENT_ROOT'].G_DIRECTORY."/rb-script/modules/";
								//echo $carpeta;

								// Leer directorio especifico en cascada (recursividad)
								function read_directory($carpeta,$nivel){
									if($dir = opendir($carpeta)){
										while(($archivo = readdir($dir)) !== false){
											if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
												// Si es directorio, lee interior de carpeta
												if(is_dir($carpeta.$archivo)){
													//echo str_repeat('-',$nivel).$archivo."<br />";
													read_directory($carpeta.$archivo."/",$nivel+1);
												// Si es archivo, asegurarse que sea de extension .php
								                }else{
								                	// Solo leer archivos con extension PHP
								                	$ext = substr($archivo, strrpos($archivo, '.') + 1);
													if(in_array($ext, array("php"))){
														//echo str_repeat('-',$nivel).$archivo."<br />";

														// Estructura que debe tener las cabeceras de datos de los modulos/plugins/plantillas
														$file_headers = array(
													        'Name'        => 'Module Name',
													        'ThemeURI'    => 'Theme URI',
													        'Description' => 'Description',
													        'Author'      => 'Author',
													        'AuthorURI'   => 'Author URI',
													        'Version'     => 'Version',
													        'Template'    => 'Template',
													        'Status'      => 'Status',
													        'Tags'        => 'Tags',
													        'TextDomain'  => 'Text Domain',
													        'DomainPath'  => 'Domain Path',
																	'PluginURI' => 'Plugin URI',
																	'PageConfig' => 'PageConfig'
														);
														//echo $carpeta.$archivo."<br />";

														$data = get_file_data( $carpeta.$archivo, $file_headers);
														// Si hay informacion y esta capturara en el array, se mostrara
														if(count($data)>0):
															global $array_modules;
															$style = '';
															$action = 0;
															if (array_key_exists($data['Name'], $array_modules)){
																$style = ' style="background-color:#ecffd5" ';
																$action = 1;
															}
															?>
															<tr>
																<td <?= $style ?>></td>
																<td <?= $style ?>><strong><?= $data['Name'] ?></strong>
																	<div class="options">
																		<?php if($action==0){ ?>
																			<span><a href="modules.list.save.php?action=active&name=<?= $data['Name'] ?>&path=<?= $carpeta.$archivo ?>">Activar</a></span>
																		<?php }elseif($action==1){ ?>
																			<span><a href="modules.list.save.php?action=desactive&name=<?= $data['Name'] ?>&path=<?= $carpeta.$archivo ?>">Desactivar</a></span>
																			<?php if(isset($data['PageConfig'])){
																				?>
																				<span><a href="<?= G_SERVER ?>/rb-admin/module.php?pag=<?= $data['PageConfig'] ?>">Configurar</a></span>
																				<?php
																			}
																			?>
																		<?php } ?>
																	</div>
																</td>
																<td <?= $style ?>>
																	<p><?= $data['Description'] ?></p>
																	<p><a target="_blank" href="<?= $data['PluginURI'] ?>">Soporte</a></p>
																	<!--<?= $carpeta.$archivo ?>-->
																	<span class="info">Versión: <?= $data['Version'] ?></span>
																</td>
															</tr>
															<?php
														endif;
													}
								                }
											}
										}
										closedir($dir);
									}
								}

								// Si es directorio explorar
								read_directory($carpeta,0);
								?>
							</tbody>
						</table>
					</section>
				</div>
				<?php
			endif;
		}

		add_function('module_content_main' , 'listado_modulos');

		do_action('module_content_main') ?>
	</div>
</section>
<?php include_once 'footer.php' ?>
