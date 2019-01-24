<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';

/* parametros inciales */
$file_prefix = "pedido";
$table_name = "rest_pedido";
$key = "rest_pedido";
$module_dir = "restaurant";
$save_path = G_DIR_MODULES_URL.$module_dir."/".$file_prefix.".save.php";
$urlreload = G_SERVER.'/rb-admin/module.php?pag='.$key;
$anular_path = G_DIR_MODULES_URL.$module_dir."/".$file_prefix.".anular.php";

// Consultar si hay pedido abiertos en esta mesa
$qp = $objDataBase->Ejecutar("SELECT * FROM rest_pedido WHERE mesa_id=".$_GET['mesa']." AND estado = 1 ORDER BY id DESC LIMIT 1");

if($qp->num_rows > 0){ // Si hay un pedido activo aun en mesa
	// Consultar detalles del pedido
	$pedido = $qp->fetch_assoc();
}

if(!isset($_GET['mesa']) || $_GET['mesa']==0 || empty($_GET['mesa'])){
	die("Ninguna mesa seleccionada.");
}
$qm = $objDataBase->Ejecutar("SELECT * FROM rest_mesa WHERE id=".$_GET['mesa']);
$mesa = $qm->fetch_assoc();
?>
<h1 style="text-align:center">Pedido de  <?= $mesa['nombre'] ?></h1>
<form id="frmNewEdit" class="form" style="max-width:600px">
	<input type="hidden" id="plato_id_temp" />
	<input type="hidden" id="plato_prec_temp" />
	<input type="hidden" name="mesa_id" id="mesa_id" value="<?= $mesa['id'] ?>" />
	<input type="hidden" id="pedido_id" name="id" value="<?php if(isset($pedido)) echo $pedido['id']; ?>" required />
	<input type="hidden" name="platos_json" id="platos_json" />
	<!-- campos inicio -->
  <label>
    Personal (codigo autorizacion)
    <input type="password" name="personal_code" required autocomplete="off" />
  </label>
	<div class="cols-container container_plato_filter">
		<div class="cols-8-md">
			<label class="cover_plato_filter">
		    Plato
		    <input id="plato_nombre" type="text" name="plato_nombre" placeholder="Escriba nombre del plato" autocomplete="off" />
				<span class="error_msg" id="err_plato"></span>
				<div class="cover_platos_list">
					<ul class="platos_list">
						<?php
						$qp = $objDataBase->Ejecutar("SELECT * FROM rest_plato ORDER BY nombre");
						while($plato = $qp->fetch_assoc()){
							$photo = rb_get_photo_details_from_id($plato['foto_id']);
							?>
							<li>
								<a class="plato" data-id="<?= $plato['id'] ?>" data-precio="<?= $plato['precio'] ?>" href="#">
									<img style="max-width:50px" src="<?= $photo['thumb_url'] ?>" alt="imagen" /><?= $plato['nombre'] ?> : S/ <?= $plato['precio'] ?>
								</a>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
			</label>
		</div>
		<div class="cols-2-md">
			<label>
		    Cantidad
		    <input id="plato_cantidad" type="number" name="plato_cantidad" autocomplete="off" />
				<span class="error_msg" id="err_cant"></span>
		  </label>
		</div>
		<div class="cols-2-md">
			<button class="btnAdd" type="button">Añadir</button>
		</div>
	</div>
	<div class="pedido_detalles">
		<?php
		if(isset($pedido)){
			$qpd = $objDataBase->Ejecutar("SELECT * FROM rest_pedido_detalles WHERE pedido_id=".$pedido['id']);
			while ($pedido_detalle = $qpd->fetch_assoc()) {
				$qpl = $objDataBase->Ejecutar("SELECT * FROM rest_plato WHERE id=".$pedido_detalle['plato_id']);
				$plato = $qpl->fetch_assoc();
				?>
				<div class="cols-container plato-item" data-id="<?= $pedido_detalle['plato_id'] ?>" data-prec="<?= $pedido_detalle['precio'] ?>" data-cant="<?= $pedido_detalle['cantidad'] ?>">
					<div class="cols-7-md"><?= $plato['nombre'] ?></div>
					<div class="cols-2-md"><?= $pedido_detalle['cantidad'] ?></div>
					<div class="cols-2-md"><?= $pedido_detalle['precio'] ?></div>
					<div class="cols-1-md"><a class="delete" title="Quitar" href="#">x</a></div>
				</div>
				<?php
			}
		}
		?>
	</div>
	<!-- campos final -->
  <div class="cols-container">
    <div class="cols-4-md cols-content-left">
      <button type="submit" class="btnSend" <?php if(!isset($pedido)){ ?> style="display:none" <?php } ?>>
				<?php
				if(isset($pedido)) echo "Actualizar el pedido";
				else echo "Genera el pedido";
				?>
			</button>
    </div>
		<div class="cols-4-md cols-content-center">
			<?php if(isset($pedido)){ ?><button type="button" class="btnAnular">Anular pedido</button><?php } ?>
		</div>
    <div class="cols-4-md cols-content-right">
      <button type="button" class="CancelFancyBox">Cerrar</button>
    </div>
  </div>
</form>
<script>
	$(document).ready(function() {
    // Boton Cancelar
    $('.CancelFancyBox').on('click',function(event){
			$.fancybox.close();
		});

		// BUSCAR PLATO ESCRIBIENDO SU NOMBRE
		// =======================================
		$('#plato_nombre').keyup(function(event){
			text_search = $(this).val();
			if(text_search.length == 0){
				$('#plato_id_temp').val("");
				$('.cover_platos_list').hide();
			}else{
				$('.cover_platos_list').show();
			}
			$(".platos_list > li").each(function() {
				if ($(this).text().search(new RegExp(text_search, "i")) > -1) { // No sensible a Mayus-Minusc
					$(this).show();
				}else{
					$(this).hide();
				}
			});
		});

		// CLICK EN EL PLATO
		// =======================================
		$('.plato').click(function(event){
			var text_item = $(this).closest('li').text().trim();
			console.log(text_item);
			$('#plato_nombre').val(text_item);
			$('#plato_cantidad').focus();
			$('.cover_platos_list').hide();
			$('#plato_id_temp').val( $(this).attr( "data-id" ) );
			$('#plato_prec_temp').val( $(this).attr( "data-precio" ) );
		});

		// AÑADIR PUBLICACION
		// =======================================
		$('.btnAdd').click(function (event){
			event.preventDefault();

			// validaciones
			var plato_id = $('#plato_id_temp').val();
			var plato_prec = $('#plato_prec_temp').val();
			var plato_name = $('#plato_nombre').val();
			var plato_cant = $('#plato_cantidad').val();

			if(plato_id == "" || plato_name == ""){
				$('#plato_nombre').addClass('error');
				$('#err_plato').text("El plato no se reconoce");
				return false;
			}else{
				$('#plato_nombre').removeClass('error');
				$('#err_plato').text("");
			}
			if(plato_cant == "" || plato_cant == 0 || plato_cant < 0){
				$('#plato_cantidad').addClass('error');
				$('#err_cant').text("Ingresa cantidad correctamente");
				return false;
			}else{
				$('#plato_cantidad').removeClass('error');
				$('#err_cant').text("");
			}

			// Buscar repetido
			if( $(".plato-item").length > 0){
				// Buscar repetido
				var repetido = false;
				$(".pedido_detalles .plato-item").each(function(){
    	    // Si existe reemplazar
					if( $(this).attr("data-id") == plato_id ){
						console.log("repetido");
						$(this).replaceWith(
							'<div class="cols-container plato-item" data-id="'+plato_id+'" data-prec="'+plato_prec+'" data-cant="'+plato_cant+'"><div class="cols-7-md">'+plato_name+'</div><div class="cols-2-md">'+plato_cant+'</div><div class="cols-2-md">'+plato_prec+'</div><div class="cols-1-md"><a class="delete" title="Quitar" href="#">x</a></div></div>'
						);
						repetido = true;
					}
    		});
				if(repetido==false) add(plato_id, plato_name, plato_cant, plato_prec);
			}else{
				add(plato_id, plato_name, plato_cant, plato_prec);
				$('.btnSend').show();
			}
				// limpiar datos y poner cursor
			$('#plato_nombre').val("");
			$('#plato_cantidad').val("");
			$('#plato_id_temp').val("");
			$('#plato_nombre').focus();
		});

		// ELIMINAR PLATO DE LISTA TEMPORAL
		// =======================================
		$('.pedido_detalles').on('click', '.delete', function(event){
			$(this).closest('.plato-item').remove();
			if( $(".plato-item").length == 0){
				$('.btnSend').hide(); // ocultar boton submit sino hay elementos a guardar
			}
		});

		// FUNCION AÑADIR PLATO AL PEDIDO
		// =====================================
		function add(plato_id, plato_name, plato_cant, plato_prec){
			$('.pedido_detalles').append(
				'<div class="cols-container plato-item" data-id="'+plato_id+'" data-prec="'+plato_prec+'" data-cant="'+plato_cant+'"><div class="cols-7-md">'+plato_name+'</div><div class="cols-2-md">'+plato_cant+'</div><div class="cols-2-md">'+plato_prec+'</div><div class="cols-1-md"><a class="delete" title="Quitar" href="#">x</a></div></div>'
			);
		}

		// GENERAR PEDIDO
		// =======================================
		$('#frmNewEdit').submit(function(event){
			event.preventDefault();
			var platos = {};
			$(".plato-item").each(function(index, element){
					plato_id = $(element).attr("data-id");
					plato_prec = $(element).attr("data-prec");
					plato_cant = $(element).attr("data-cant");

					//JavaScript does not support arrays with named indexes.
					//plato = new Array( plato_id,  plato_cant, plato_prec);
					plato = {};
					plato['plato_id'] = plato_id;
					plato['cant'] = plato_cant;
					plato['prec'] = plato_prec;

					//platos.push(plato);
					platos[plato_id] = plato;
			});
			var platosJson = JSON.stringify(platos);
			console.log(platos);
			console.log(platosJson);
			$('#platos_json').val(platosJson);

			$.ajax({
				method: "post",
				url: "<?= $save_path ?>",
				data: $( this ).serialize()
			})
			.done(function( data ) {
				if(data.resultado){
					$.fancybox.close();
					notify(data.contenido);
					setTimeout(function(){
						window.location.href = '<?= $urlreload ?>';
					}, 1000);
				}else{
					notify(data.contenido);
				}
			});
		});

		// ANULADO PEDIDO
		// =======================================
		$('.btnAnular').click(function (event){
			event.preventDefault();
      var anula = confirm("¿Confirma anulacion del pedido?");
      if ( anula ) {
				var pedido_id = $('#pedido_id').val();
				$.ajax({
					method: "get",
					url: "<?= $anular_path ?>?pedido_id="+pedido_id,
					cache: false
				})
				.done(function( data ) {
					if(data.resultado){
						$.fancybox.close();
						notify(data.contenido);
						setTimeout(function(){
							window.location.href = '<?= $urlreload ?>';
						}, 1000);
					}else{
						notify(data.contenido);
					}
				});
			}
		});
  });
</script>
