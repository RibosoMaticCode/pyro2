<?php
include 'islogged.php';
?>
<script type="text/javascript">
function Consult(page,sec,other,format){
	if(page=='undefined'){
		page=0;
	}
	//other used for aditional variables

	// listdata
   	$.ajax({
       	url: 'listado.php?page='+page+'&sec='+sec+other,
       	cache: false,
     	type: "GET",
		success: function(datos){
			switch(format){
				case 'grid':
					$("ul#grid").html(datos);
					$(window).resize();
				break;
				default:
					$("tbody#itemstable").html(datos);
			}
       	}
  	});
	// pagination
   	$.ajax({
       	url: 'paginate.php?page='+page+'&sec='+sec,
       	cache: false,
     	type: "GET",
		success: function(datos1){
			$("#pagination").html(datos1);
       	}
  	});
}

function Search(page, sec){
	// search listdata
	var term = $('#search-input').attr('value');

   	$.ajax({
       	url: 'listado.php?term='+term+'&page='+page+'&sec='+sec,
       	cache: false,
     	type: "GET",
		success: function(datos){
			$("tbody").html(datos);
       	}
  	});

	//search pagination
   	$.ajax({
       	url: 'paginate.php?term='+term+'&page='+page+'&sec='+sec,
       	cache: false,
     	type: "GET",
		success: function(datos){
			$("#paginate").html(datos);
       	}
  	});
}
function Delete(id,sec,user_id,other){
	// delete
	var eliminar = confirm("[?] Esta a punto de eliminar este dato. Continuar?");

	if ( eliminar ) {
		$.ajax({
			url: 'all.delete.php?id='+id+'&sec='+sec+'&uid='+user_id+'&_other='+other,
			cache: false,
			type: "GET",
			success: function(datos){
				notify('El dato fue eliminado correctamente.');

				switch(sec){
					case 'img':
						Consult(0,sec,"&album_id="+other,"grid");
						break;
					case 'files':
						Consult(0,sec,"","grid");
						break;
					default:
						Consult(0,sec,"",""); // por defecto presentacion: table
				}
			}
		});
	}
}
$(document).ready(function() {
    $('#select_all').change(function(){
        var checkboxes = $(this).closest('table').find(':checkbox');
        if($(this).prop('checked')) {
          checkboxes.prop('checked', true);
        } else {
          checkboxes.prop('checked', false);
        }
    });
	$('#edit').click(function( event ){
		var len = $('input:checkbox[name=items]:checked').length;
		if(len==0){
			alert("[!] Seleccione un elemento a editar");
		}
		if(len>1){
		 	alert("[!] Seleccione solo un elemento a editar");
		}
		//select section then call function load_edit_form
		sect = $(this).attr('rel');

		if(len==1){
			$('input:checkbox[name=items]:checked').each(function(){
				item_id = $(this).val();
				load_edit_form(item_id,sect);
			});
		}
	});

	$('#delete').click(function( event ){
		var len = $('input:checkbox[name=items]:checked').length;
		if(len==0){
			alert("[!] Seleccione un elemento a eliminar");
			return;
		}

		var eliminar = confirm("[?] Esta seguro de eliminar los "+len+ " items?");
		//alert("[?] Esta seguro de eliminar los "+len+ " items?");
		var sec = $(this).attr('rel');
		var albumid = $(this).attr('data-albumid');

		if ( eliminar ) {
			$('input:checkbox[name=items]:checked').each(function(){
				item_id = $(this).val();

				if(sec == "img"){
					url = 'all.delete.php?id='+item_id+'&sec='+sec+'&uid=0&_other='+albumid;
				}else{
					url = 'all.delete.php?id='+item_id+'&sec='+sec;
				}

				$.ajax({
					url: url,
					cache: false,
					type: "GET",
				});
			});

			notify('Los datos fueron eliminados correctamente.');

			switch(sec){
				case 'img':
					Consult(0,sec,"&album_id="+albumid,"grid");
					break;
				case 'files':
					Consult(0,sec,"","grid");
					break;
				default:
					Consult(0,sec,"",""); // por defecto presentacion: table
			}
		}
	});
});

function change_items_show(){
	var nums_items_show = $('#nums_items_show').val();
	var section = $('#nums_items_show').attr("name");

	$(location).attr('href','ajaxoptions.php?value='+nums_items_show+'&sec='+section);
}

function load_edit_form(item_id,sect){
	window.location.href = "<?php echo G_SERVER ?>/rb-admin/index.php?pag="+sect+"&opc=edt&id="+item_id;
}
function load_page(page_string){
	window.location.href = "<?php echo G_SERVER ?>/"+page_string;
}

</script>
<?php
switch($sec){
	//SECCION FILES  ------------------------->>>>>>>>>>>>
	case "files":
	?>
		<?php if (!in_array("files", $array_help_close)): ?>
		<div class="help" data-name="files">
			<h4>Información</h4>
			<p>Puedes subir tus archivos necesarios para asociarlos con los contenidos que generes en el sitio.</p>
			<p>Para <strong>imágenes de productos</strong>, recomendamos una dimensión mínima de <strong>400x400</strong> píxeles.</p>
		</div>
		<?php endif ?>
		<div id="sidebar-left">
            <ul class="buttons-edition">
            <li><a class="btn-primary" href="../rb-admin/?pag=files&amp;opc=nvo"><img src="img/add-white-16.png" alt="Cargar" /> Cargar Archivo</a></li>
			<li><a class="btn-primary" rel="file_edit" href="#" id="edit"><img src="img/edit-white-16.png" alt="Editar" /> Editar</a></li>
			<li><a class="btn-primary" rel="files" href="#" id="delete"><img src="img/del-white-16.png" alt="delete" /> Eliminar</a></li>
            </ul>
		</div>
		<div class="content">
        	<div id="content-list">
                <div id="resultado"> <!-- ajax asyncron here -->
                    <ul id="grid" class="wrap-grid">
                    <?php include('listado.php') ?>
                    </ul>
                </div>
            </div>
		</div>
	<?php
	break;
	//SECCION GALERIA  ------------------------->>>>>>>>>>>>
	case "gal":
	?>
		<?php if (!in_array("gal", $array_help_close)): ?>
		<div class="help" data-name="gal">
           	<h4>Información</h4>
			<p>Las <strong>Galerías</strong> permiten agrupar u organizar solo imágenes. Se puede asociar con alguna Publicacion ó Pagina.</p>
		</div>
		<?php endif ?>
		<div id="sidebar-left">
            <ul class="buttons-edition">
			<li><a class="btn-primary" href="../rb-admin/index.php?pag=gal&amp;opc=nvo"><img src="img/add-white-16.png" alt="Editar" /> Nuevo</a></li>
			<li><a class="btn-primary" rel="gal" href="#" id="edit"><img src="img/edit-white-16.png" alt="Editar" /> Editar</a></li>
			<li><a class="btn-primary" rel="gal" href="#" id="delete"><img src="img/del-white-16.png" alt="delete" /> Eliminar</a></li>
            </ul>
		</div>
		<div class="content">
        	<!--<div id="content-list">-->
        	<div class="wrap-content-list">
        		<section class="seccion">
                <div id="resultado"> <!-- ajax asyncron here -->
                <table id="t_articulos" class="tables" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                        	<th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
                        	<th width="250px;"><h3>Nombre</h3></th>
                        	<th><h3>Descripción</h3></th>
                            <th width="250px;"><h3>Fecha</h3></th>
                            <th width="30px;"><h3>Imagenes</h3></th>
                        </tr>
                    </thead>
                    <tbody id="itemstable">
                    <?php include('listado.php') ?>
                    </tbody>
                </table>
                </div>
                </section>
            </div>
		</div>
	<?php
	break;
	//SECCION IMAGENES  ------------------------->>>>>>>>>>>>
	case "img":
		require_once(ABSPATH."rb-script/class/rb-galerias.class.php");

		$album_id = $_GET["album_id"];
		$result_g = $objGaleria->Consultar("SELECT nombre FROM albums WHERE id=".$album_id);
        $row_g = mysql_fetch_array($result_g);
	?>
		<h2 class="title"><?= $row_g['nombre'] ?></h2>
		<div class="page-bar">Inicio > Medios > Galerías</div>

		<div id="sidebar-left">
            <ul class="buttons-edition">
			<li><a class="btn-primary" href="../rb-admin/?pag=gal">Volver</a></li>
            <li><a class="btn-primary" href="../rb-admin/?pag=imgnew&amp;opc=nvo&amp;album_id=<?php echo $album_id ?>"><img src="img/add-white-16.png" alt="Cargar" /> Agregar nuevo item</a></li>
			<li><a class="btn-primary" rel="img" href="#" id="edit"><img src="img/edit-white-16.png" alt="Editar" /> Editar</a></li>
			<li><a class="btn-primary" rel="img" data-albumid="<?php echo $album_id ?>" href="#" id="delete"><img src="img/del-white-16.png" alt="delete" /> Eliminar</a></li>
			<li><a class="btn-primary" href="#" id="imgSaveOrder">Guardar orden</a></li>
            </ul>
		</div>
		<div class="content">
        	<div id="content-list">
                <div id="resultado"> <!-- ajax asyncron here -->
                	<script src="<?= G_SERVER ?>/rb-admin/resource/ui/jquery-ui.js"></script>
                	<script>
  					$(function() {
    					$( "#grid" ).sortable();
    					$( "#grid" ).disableSelection();

    					$( '#imgSaveOrder').click ( function ( event ){
    						/*var jsonOrder = "{";
    						var coma = "";*/
    						var files = [];
    						$( "#grid li" ).each(function( index ) {
    							files.push({
							        id: $( this ).attr('data-id'),
							        order: index
							    });
    							/*files["id"] =
    							files["order"] = index*/
	  							//var file_id = $( this ).attr('data-id');
	  							//jsonOrder += coma +" '"+file_id+"' : '"+index + "'";
	  							//coma = ",";
							});
							/*jsonOrder += "}";*/
							files = JSON.stringify( files );
							console.log( files );

							$.ajax({
								method: "GET",
								url: "gallery.img.save.order.php",
								data: { jsonOrder : files }
							}).done(function( msg ) {
							    console.log( msg );
							});
    					});
  					});
  					</script>
                    <ul id="grid" class="wrap-grid">
                    <?php include('listado.php') ?>
                    </ul>
                    <!--</tbody>
                </table>-->
                </div>
            </div>
		</div>
	<?php
	break;
	//SECCION COMENTARIOS ------------------------->>>>>>>>>>>>
	case "com":
		require_once(ABSPATH."rb-script/class/rb-articulos.class.php");
	?>
		<?php if (!in_array("com", $array_help_close)): ?>
		<div class="help" data-name="com">
			<h4>Información</h4>
				<p>
            		Aquí se listan los <strong>Comentarios</strong> de los usuarios, visitantes en el sitio web. Puedes filtrar por la publicación, para ver sus comentarios.</p>
            	<p>
            		* Agregar y Ver los comentarios, dependerá de la plantilla instalada en el sistema.</p>
		</div>
		<?php endif ?>
		<div id="sidebar-left">
            <ul class="buttons-edition">
				<?php
				// si variable art esta definida entonces
				if(isset($_GET['art'])) {
					$q = $objArticulo->Consultar("SELECT titulo FROM articulos WHERE id=".$_GET['art']);
					$r = mysql_fetch_array($q);
					?>
					<li><a href="../rb-admin/?pag=com&amp;art=<?php echo $_GET['art'] ?>">Comentarios en <em><?php echo $r['titulo'] ?></em></a></li>
				<?php } ?>

				<li><a class="btn-primary" rel="com" href="#" id="edit"><img src="img/edit-white-16.png" alt="Editar" /> Editar</a></li>
				<li><a class="btn-primary" rel="com" href="#" id="delete"><img src="img/del-white-16.png" alt="Eliminar" /> Eliminar</a></li>
            </ul>
		</div>

		<div class="wrap-content-list">
        	<section class="seccion">
	        	<div id="content-list">
	                <div id="resultado">
	                <table id="t_comentarios" class="tables" border="0" cellpadding="0" cellspacing="0">
	                <thead>
	                    <tr>
	                    	<th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
	                        <th style="width:10%"><h3>Autor</h3></th>
	                        <th><h3>Comentario</h3></th>
	                        <th style="width:30%"><h3>Publicación comentada</h3></th>
	                    </tr>
	                </thead>
	                <tbody id="itemstable">
	                <?php
	                    include('listado.php');
	                ?>
	                </tbody>
	                </table>
	                </div>
				</div>
				<div id="pagination">
				<?php if(!isset($_GET['art'])) include('paginate.php') ?>
				</div>
			</section>
		</div>
	<?php
	break;
	//SECCION CATEGORIAS ------------------------->>>>>>>>>>>>
	case "cat":
	?>
		<?php if (!in_array("cat", $array_help_close)): ?>
		<div class="help" data-name="cat">
			<h4>Información</h4>
			<p>Una <strong>Categoria</strong> permite agrupar las publicaciones.</p><p>Es importante que por lo menos haya una, pues no se podrá guardar una publicación sino hay una Categoría.</p>
		</div>
		<?php endif ?>
		<div id="sidebar-left">
            <ul class="buttons-edition">
			<li><a class="btn-primary" href="../rb-admin/?pag=cat&amp;opc=nvo"><img src="img/add-white-16.png" alt="Nuevo" /> Nueva Categoria</a></li>
            </ul>
		</div>
		<div class="wrap-content-list">
			<section class="seccion">
        	<div id="content-list">
                <div id="resultado">
                <table id="t_categorias" class="tables" border="0" cellpadding="0" cellspacing="0">
                <thead>
                  <tr>
                    <th><h3>Nombre</h3></th>
                    <th><h3>Descripcion</h3></th>
                    <th><h3>Acceso</h3></th>
                    <th><h3>Niveles</h3></th>
                    <th colspan="2"><h3>Acciones</h3></th>
                  </tr>
                 </thead>
                <tbody id="itemstable">
                    <?php include('listado.php') ?>
                </tbody>
                </table>
                </div>
            </div>
            </section>
		</div>
	<?php
	break;
	//SECCION MENSAJES  ------------------------->>>>>>>>>>>>
	case "men":
	?>	<?php if (!in_array("men", $array_help_close)): ?>
		<div class="help" data-name="men">
			<h4>Información</h4>
			<p>Puede enviar y recibir notificaciones de otros usuario del sistema. Funciona similar a una bandeja de correo electrónico, muy básica</p>
		</div>
		<?php endif ?>
		<div id="sidebar-left">
            <ul class="buttons-edition">
			<li><a class="btn-primary" <?php echo $style_btn_default ?>href="../rb-admin/?pag=men">Recibidos</a></li>
            <li><a class="btn-primary" <?php echo $style_btn_1 ?>href="../rb-admin/?pag=men&opc=send">Enviados</a></li>
			<li><a class="btn-primary" href="../rb-admin/?pag=men&amp;opc=nvo"><img src="img/add-white-16.png" alt="Nuevo" /> Nuevo</a></li>
            </ul>
		</div>
		<div class="wrap-content-list">
			<section class="seccion">
        	<div id="content-list">
                <div id="resultado">
                <table id="t-enlaces" class="tables" border="0" cellpadding="0" cellspacing="0">
                <thead>
                  <tr>
                    <th><h3>Asunto</h3></th>
                    <?php if(isset($_GET['opc']) && $_GET['opc'] =="send"){ ?> <th><h3>Destinatarios</h3></th>
                    <?php }else{ ?> <th><h3>Remitente</h3></th><?php } ?>

                    <th><h3>Fecha</h3></th>
                    <th><h3>Acciones</h3></th>
                  </tr>
                </thead>
                <tbody>
                <?php
                    include('listado.php');
                ?>
                </tbody>
                </table>
                </div>
			</div>
			</section>
		</div>
	<?php
	break;
}
?>
