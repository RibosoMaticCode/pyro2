<?php
// MOSTRAR LA ESTRUCTURA DE EDICION DEL MENU
require_once(ABSPATH."rb-script/class/rb-articulos.class.php");
$mainmenu_id = $_GET['id'];
$menu_asincrono = true;
?>
<script src="<?= G_SERVER ?>/rb-admin/resource/ui/jquery-ui.js"></script>
<script>
	$(document).ready(function() {		
		$( ".column" ).sortable({
			connectWith: ".column",
			handle: ".header",
			placeholder: "placeholder"
	    });
	    
		// ocultar/mostrar cuerpo del item
		$("#subitems").on("click", ".more", function (event) {
		   	event.preventDefault();
		   	$(this).closest("li").find("> .item-body").slideToggle(); // ">" solo aplica al primer elemento, sino aplicaria a todo los item-body dentro del li padre
		});	
			    
		// Cambiar titulo del item
		$("#subitems").on("keyup", ".menu_title", function (event) {
		   	//console.log( $(this).val() );
		   	$(this).closest("li").find(".item-title").html( $(this).val() );
		   	$(this).closest("li").attr("data-title", $(this).val());
		});
		
		// Cambiar estilo del item
		$("#subitems").on("keyup", ".menu_style", function (event) {
		   	//console.log( $(this).val() );
		  	$(this).closest("li").attr("data-style", $(this).val());
		});
		
		// Cambiar estilo del url
		$("#subitems").on("keyup", ".menu_url", function (event) {
		   	//console.log( $(this).val() );
		  	$(this).closest("li").attr("data-url", $(this).val());
		});
			    
		<?php
		// consultar ultimo id dentro de la table menus
		require_once(ABSPATH."rb-script/class/rb-menus.class.php");
		$row = mysql_fetch_array($objMenu->Consultar("SELECT * FROM menus_items ORDER BY id DESC LIMIT 1"));
		?>
		
		// añadir un nuevo item, con todo el form para configurar
		var last_item = <?= $row['id'] ? $row['id'] : "1" ?>;

		// GUARDAR ESTRUCTURA DEL MENU EN JSON
		$('#savesubitems').click(function( event ){
			// Agradecimiento: http://stackoverflow.com/questions/7932931/json-and-jquery-create-nested-json-from-nested-list-elements#_=_
			var out = []; // variable array
						 
		    function processOneLi(node) {  
		    	// node contiene el elemento "li" que se pasa como parametro     
		        //var aNode = node.children("a:first");
		        //node.attr()
		        var retVal = {
		        	"id": node.attr('data-id'),
		            "title": node.attr('data-title'),
		            "style": node.attr('data-style'),
		            "url": node.attr('data-url'),
		            "menumain": node.attr('data-menumain'),
		            "type": node.attr('data-type')
		        };
		        // Busca en la lista si hay una clase .hidden con elemento li.
		        node.find("> .sortable > li").each(function() {
		        	// Si no existe la propiedad "children", añadirmos un nuevo valor al array "children", que contendra un array
		            if (!retVal.hasOwnProperty("children")) { // hasOwnProperty: Verifica existencia de una propiedad. En el ej. verifica si existe "nodes"
		            	// Añadirmos a reval, un nuevo elemento "children", que contendra un array
		            	retVal.children = [];
		            }
					retVal.children.push(processOneLi($(this)));
				});
				return retVal;
			}
			
			$(".menu-edition > ul > li").each(function() {
				out.push(processOneLi($(this)));
			});

			console.log(JSON.stringify(out));
			$.ajax({
				type: 'POST',
				url: '<?= G_SERVER ?>/rb-script/modules/rb-menus/save.menus.php',
				data: {
					mainmenu_id: <?= $mainmenu_id ?>, 
					json: JSON.stringify(out)},
				dataType: 'json'
			})
			.done( function (data){
				window.location.href = '<?=  G_SERVER ?>/rb-admin/index.php?pag=menu&id=<?= $mainmenu_id ?>&m=ok';
			});		    
		});

				// CLICK EN LOS BOTONES DE TIPO DE ITEMS DE MENU
				$('#btn-list-pag').click(function( event ){
					$('#btn-list-pag, #btn-list-art, #btn-list-cat, #btn-list-per').removeClass('item-menu-selected');
					$('#list-pag, #list-art, #list-cat, #list-per').removeClass('item-menu-selected');
					$('#btn-list-pag, #list-pag').addClass('item-menu-selected');
					$('.list-link > div').hide();
					$('#list-pag').show();
				});
				$('#btn-list-art').click(function( event ){
					$('#btn-list-pag, #btn-list-art, #btn-list-cat, #btn-list-per').removeClass('item-menu-selected');
					$('#list-pag, #list-art, #list-cat, #list-per').removeClass('item-menu-selected');								
					$('#btn-list-art, #list-art').addClass('item-menu-selected');
					$('#list-art').show();
					$('.list-link > div').hide();
					$('#list-art').show();
				});
				$('#btn-list-cat').click(function( event ){
					$('#btn-list-pag, #btn-list-art, #btn-list-cat, #btn-list-per').removeClass('item-menu-selected');
					$('#list-pag, #list-art, #list-cat, #list-per').removeClass('item-menu-selected');
					$('#btn-list-cat, #list-cat').addClass('item-menu-selected');
					$('.list-link > div').hide();
					$('#list-cat').show();
				});
				$('#btn-list-per').click(function( event ){
					$('#btn-list-pag, #btn-list-art, #btn-list-cat, #btn-list-per').removeClass('item-menu-selected');
					$('#list-pag, #list-art, #list-cat, #list-per').removeClass('item-menu-selected');
					$('#btn-list-per, #list-per').addClass('item-menu-selected');
					$('.list-link > div').hide();
					$('#list-per').show();
				});
				
				$('#btn-add-pages').click(function( event ){
					$('input[name^="paginas"]:checked').each(function() {
						var type =  $(this).attr('data-type');
						var title =  $(this).attr('data-title');
						var url =  $(this).val();

						$('#subitems').append( form_html(type, title, last_item, url) );
						last_item++;
						$( ".column" ).sortable({
					      connectWith: ".column",
					      handle: ".header",
					      placeholder: "placeholder"
					    });
					});
				});
				
				$('#btn-add-posts').click(function( event ){
					$('input[name^="articulos"]:checked').each(function() {
						var type =  $(this).attr('data-type');
						var title =  $(this).attr('data-title');
						var url =  $(this).val();

						$('#subitems').append( form_html(type, title, last_item, url) );
						last_item++;
						$( ".column" ).sortable({
					      connectWith: ".column",
					      handle: ".header",
					      placeholder: "placeholder"
					    });
					});
				});
				
				$('#btn-add-categories').click(function( event ){
					$('input[name^="categorias"]:checked').each(function() {
						var type =  $(this).attr('data-type');
						var title =  $(this).attr('data-title');
						var url =  $(this).val();

						$('#subitems').append( form_html(type, title, last_item, url) );
						last_item++;
						$( ".column" ).sortable({
					      connectWith: ".column",
					      handle: ".header",
					      placeholder: "placeholder"
					    });
					});
				});
				
				$( "#menu_item_per_frm" ).submit(function( event ) {
					event.preventDefault();
					var type =  $(this).attr('data-type');
					var title =  $('#menu_item_name').val();
					var url =  $('#menu_item_url').val();
					
					$('#subitems').append( form_html(type, title, last_item, url) );
					last_item++;
					
					$('#menu_item_per_frm').trigger("reset");
					$( ".column" ).sortable({
					      connectWith: ".column",
					      handle: ".header",
					      placeholder: "placeholder"
					    });
				});
				
				$( "#subitems" ).on( "click", ".delete", function() {
				  	$(this).closest("li").remove();
				});
				
				function form_html(type, title, last_item, url){
					var item = '<li class="item" data-id="item'+last_item+'" data-title="'+title+'" data-url="'+url+'" data-menumain="<?= $mainmenu_id ?>" data-type="'+type+'" data-style="">';
						item += '<div class="header"><span class="item-title">'+title+'</span></div>';
						item += '<a class="more" href="#"><span class="arrow-up" style="display: none;">&#9650;</span><span class="arrow-down">&#9660;</span></a>';
						item += '';
						
						item += '<div class="item-body" style="display: none">';
						item += '	<label title="Titulo del Item" for="nombre">Titulo del Item:';
						item += ' 		<input id="item-menu-name-'+last_item+'" required autocomplete="off"  name="nombre" class="menu_title" type="text" value="'+title+'" required />';
                        item += '	</label>';
                        if(type == "per"){
                        	item += '	<label title="URL" for="nombre">URL (incluir http://):';
							item += ' 		<input id="item-menu-url-'+last_item+'" required autocomplete="off"  name="url" class="menu_url" type="text" value="'+url+'" required />';
                        	item += '	</label>';
                        }
	                    item += '   <label>Estilos CSS (id):';
                       	item += '		<input id="item-menu-css-'+last_item+'" name="estilo" class="menu_style" type="text" value="" />';
                       	item += '	</label>';
                       	item += '<button class="delete">Eliminar</button>';
                   		item += '</div>';
                   		item += '<ul class="column item sortable"></ul> ';//<ul class='column item hidden'></ul>
                   		item += '</li>';
                   		
                   	return item;
				}
	});
</script>
<?php if (!in_array("menu", $array_help_close)): ?>
	<div class="help" data-name="menu">
		<h4>Información</h4>
		<p>Agrega elementos a tu menu asociados con: publicaciones, categorías, páginas ó enlace personalizables, de la sección "Elementos disponibles".</p>
		<p>En la caja con linea descontinuada, puedes mover la estructura de los elementos de tu menu hasta dar con el adecuado. Luego pulsa en Guardar Menu.</p>
		<p>Para establecerlo en la página inicial, debes ir a la seccion Opciones y establecerlo desde allí.</p>
	</div>
<?php endif ?>
<div id="sidebar-left">
	<ul class="buttons-edition">
		<li><a class="btn-primary" href="../rb-admin/?pag=menus">Volver a Todos los Menús</a></li>
		<li><a id="savesubitems" class="btn-primary" href="#">Guardar Menu</a></li>
	</ul>
</div>
<div class="content-edit">
	<section class="seccion">
		<!--<div id="content-list">
			<div id="resultado">-->
				<?php include('menu.listado.php') ?>          
			<!--</div>
		</div>
		<div id="pagination">
		</div>-->
	</section>
</div>

<div id="sidebar">
	<section class="seccion">
		<div class="seccion-header">
			<h3>Elementos disponibles</h3>
		</div>
		<div class="seccion-body">
			<ul class="items-menu-tipo">
				<li>
					<a id="btn-list-pag" href="#" class="item-menu-selected">
						Página
					</a>
				</li>
				<li>
					<a id="btn-list-art" href="#">
						Artículo
					</a>				
				</li>
				<li>
					<a id="btn-list-cat" href="#">
						Categoría
					</a>
				</li>
				<li>
					<a id="btn-list-per" href="#">
						Personalizado
					</a>
				</li>
			</ul>
			
			<div class="list-link">
				<div id="list-pag" class="item-menu-selected">
					<div class="list-pag">
					<?php
					$q = $objArticulo->Consultar("SELECT * FROM paginas");
					while($r = mysql_fetch_array($q)):
					?>
						<label class="label_checkbox"><input type="checkbox" value="<?= $r['id'] ?>" data-type="pag" data-title="<?= $r['titulo'] ?>" name="paginas[]"><?= $r['titulo'] ?></label>
					<?php
					endwhile;
					?>
					</div>
					<div>
						<button id="btn-add-pages">Añadir al Menú</button>
					</div>
				</div>
				<div id="list-art" style="display: none">
					<div class="list-art">
					<?php
					$q = $objArticulo->Consultar("SELECT * FROM articulos");
					while($r = mysql_fetch_array($q)):
					?>
						<label class="label_checkbox"><input type="checkbox" value="<?= $r['id'] ?>" data-type="art" data-title="<?= $r['titulo'] ?>" name="articulos[]"><?= $r['titulo'] ?></label>
					<?php
					endwhile;
					?>
					</div>
					<div>
						<button id="btn-add-posts">Añadir al Menú</button>
					</div>
				</div>
				<div id="list-cat" style="display: none">
					<div class="list-cat">
					<?php
					$q = $objArticulo->Consultar("SELECT * FROM categorias");
					while($r = mysql_fetch_array($q)):
					?>
						<label class="label_checkbox"><input type="checkbox" value="<?= $r['id'] ?>" data-type="cat" data-title="<?= $r['nombre'] ?>" name="categorias[]"><?= $r['nombre'] ?></label>
					<?php
					endwhile;
					?>
					</div>
					<div>
						<button id="btn-add-categories">Añadir al Menú</button>
					</div>
				</div>
				<div id="list-per" style="display: none">
					<div class="list-per">
					<form id="menu_item_per_frm" data-type="per">
						<label>
							<span>Texto del enlace</span>
							<input type="text" required name="menu_item_name" id="menu_item_name" />
						</label>
						<label>
							<span>URL</span>
							<input type="text" required name="menu_item_url" id="menu_item_url" />
						</label>
						<button id="btn-add-custom">Añadir al Menú</button>
					</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>