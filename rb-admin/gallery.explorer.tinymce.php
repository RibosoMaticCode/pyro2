<?php
/*
* Actualizacion: agregado linea meta charset utf-8, para evitar errores en caracteres especiales */
require_once '../global.php';
include 'islogged.php';
/*require_once(ABSPATH."rb-script/class/rb-galerias.class.php");
require_once(ABSPATH."rb-script/class/rb-fotos.class.php");
require_once(ABSPATH."rb-script/funciones.php");*/
if(isset($_GET['type'])):
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> <!-- ! -->
		<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>rb-admin/css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>rb-admin/css/styles2.css" />
		<link rel="stylesheet" type="text/css" href="<?= G_SERVER ?>rb-admin/css/fonts.css" />
		<script type="text/javascript" src="<?= G_SERVER ?>rb-admin/js/jquery-1.11.1.min.js"></script>
		<script>
		$(document).ready(function() {
			$('#assetResults img').on('click', function(event){
				var args    = top.tinymce.activeEditor.windowManager.getParams();
				win         = (args.window);
				input       = (args.input);
				win.document.getElementById(input).value = '<?= G_SERVER ?>rb-media/gallery/' + $(this).data('filename');
				top.tinymce.activeEditor.windowManager.close();
			});

			// Filter files
			$('#search_box').keyup(function(){
				var valThis = $(this).val();
		    $('.gallery>li').each(function(){
					var text = $(this).find('span').text().toLowerCase();
					(text.indexOf(valThis) == 0) ? $(this).show() : $(this).hide();
		   	});
			});
		});
		</script>
	</head>
	<body>
		<div class="explorer-body">
			<div class="search-bar">
				<input type="text" id="search_box" placeholder="Archivo a buscar" />
			</div>
			<div id="photos">
				<div class="explorer-body-inner">
					<div id="assetResults" class="flibrary">
						<ul class="gallery pop_library">
						<?php
						if($_GET['type']=="image"):
							$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."files WHERE type LIKE 'image%' ORDER BY id DESC");
						elseif($_GET['type']=="file"):
							$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."files ORDER BY id DESC");
						endif;
						while ($row = $q->fetch_assoc()):
							?>
							<li>
								<a class="explorer-file" datafld="<?= utf8_encode($row['src']) ?>" datasrc="<?= $row['id'] ?>" href="#" data-type="<?= $row['type'] ?>">
									<?php
									if(rb_file_type($row['type']) == "image"):
										echo '<img class="thumb" src="'.G_SERVER.'/rb-media/gallery/tn/'.utf8_encode($row['tn_src']).'" data-filename="'.utf8_encode($row['tn_src']).'" />';
									else:
										if( rb_file_type( $row['type'] )=="pdf" ) echo '<img src="img/pdf.png" alt="png" data-filename="'.(utf8_encode($row['tn_src'])).'" />';
										if( rb_file_type( $row['type'] )=="word" ) echo '<img src="img/doc.png" alt="png" data-filename="'.(utf8_encode($row['tn_src'])).'" />';
										if( rb_file_type( $row['type'] )=="excel" ) echo '<img src="img/xls.png" alt="png" data-filename="'.(utf8_encode($row['tn_src'])).'" />';
									endif;
									?>
									<span><?= utf8_encode($row['tn_src']) ?></span>
								</a>
							</li>
						<?php
						endwhile;
						?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
endif;
?>
