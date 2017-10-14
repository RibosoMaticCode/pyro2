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
	//SECCION COMENTARIOS ------------------------->>>>>>>>>>>>
	case "com":
		require_once(ABSPATH."rb-script/class/rb-database.class.php");
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
					$q = $objDataBase->Ejecutar("SELECT titulo FROM articulos WHERE id=".$_GET['art']);
					$r = $q->fetch_assoc();
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
}
?>
