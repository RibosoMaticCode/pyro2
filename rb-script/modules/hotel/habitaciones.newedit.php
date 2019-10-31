<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';

/* parametros inciales */
$file_prefix = "habitaciones";
$table_name = "hotel_habitacion";
$key = "hotel_habitaciones";
$module_dir = "hotel";
$save_path = G_DIR_MODULES_URL.$module_dir."/".$file_prefix.".save.php";
$urlreload=G_SERVER.'rb-admin/module.php?pag='.$key;

/* start */
if( isset($_GET['id']) ){
  $id=$_GET['id'];
  $q = $objDataBase->Ejecutar("SELECT * FROM $table_name WHERE id=$id");
  $row = $q->fetch_assoc();
}else{
  $id = 0;
}
?>
<form id="frmNewEdit" class="form" style="max-width:800px">
	<div class="cols-container">
		<div class="cols-5-md col-padding-right">
			<h3 class="title">Datos de la habitacion</h3>
			<input type="hidden" name="id" value="<?= $id ?>" required />
			<!-- campos inicio -->
		  <label>
		    Numero de habitacion
		    <input type="text" name="numero_habitacion" required value="<?php if(isset($row)) echo $row['numero_habitacion'] ?>" />
		  </label>
		  <label>
		    Tipo
		    <input type="text" name="tipo" required value="<?php if(isset($row)) echo $row['tipo'] ?>" />
		  </label>
		  <label>
		    Detalles
		    <textarea name="detalles"><?php if(isset($row)) echo $row['detalles'] ?></textarea>
		  </label>
		  <label>
		    Servicios
		    <textarea name="servicios"><?php if(isset($row)) echo $row['servicios'] ?></textarea>
		  </label>
		  <label>
		    Anexar galeria
				<select name="galeria_id">
					<option value="0">Seleccionar galeria</option>
					<?php
					$galleries = rb_list_galleries();
					foreach($galleries as $gallery){
						?>
						<option <?php if(isset($row) && $row['galeria_id']==$gallery['id']) echo "selected" ?> value="<?= $gallery['id'] ?>"><?= $gallery['nombre'] ?> (<?= $gallery['nrophotos'] ?>)</option>
						<?php
					}
					?>
				</select>
		  </label>
			<label>
		    Precio
		    <input type="number" name="precio" value="<?php if(isset($row)) echo $row['precio'] ?>" />
		  </label>
		</div>
		<div class="cols-7-md col-padding-left">
			<h3 class="title">Inventario de la habitacion</h3>
			<div id="ensere_grupo" class="ensere_grupo">
				<?php
				if(isset($row)){
					if( empty($row['enseres']) ){
						$json_enseres = "[]";
					}else{
						$json_enseres = $row['enseres'];
					}
					$enseres = json_decode ($json_enseres, true);
					if(count($enseres)>0){
						foreach($enseres as $ensere){
							?>
							<div class="ensere_item">
								<div>
									<label>
										Ensere
										<input type="text" name="grupo_ensere[]" value="<?= $ensere['ensere'] ?>" />
									</label>
								</div>
								<div>
									<label>
										Cantidad
										<input type="text" name="grupo_cantidad[]" value="<?= $ensere['cantidad'] ?>" />
									</label>
								</div>
								<div class="remove_cover">
									<a class="remove_item" href="#"><i class="fa fa-times"></i></a>
								</div>
							</div>
							<?php
						}
					}
				}
				?>
			</div>
			<a class="add_item" href="#">Añadir menaje</a>
		</div>
	</div>
	<!-- campos final -->
  <div class="cols-container">
    <div class="cols-6-md cols-content-left">
      <button class="button btn-primary" type="submit">Guardar</button>
    </div>
    <div class="cols-6-md cols-content-right">
      <button type="button" class="button CancelFancyBox">Cancelar</button>
    </div>
  </div>
</form>
<script>
	$(document).ready(function() {
		// Add element to grupo familiar
    $('.add_item').on('click',function(event){
      $.ajax({
  			method: "get",
  			url: "<?= G_SERVER ?>rb-script/modules/hotel/newmenaje.html"
  		})
  		.done(function( data ) {
  			$('.ensere_grupo').append(data);
  		});
    });

    // Quitar element to grupo familiar
    $("#ensere_grupo").on("click", ".remove_item", function (event) {
      event.preventDefault();
		  $(this).closest(".ensere_item").remove();
    });

    // Boton Cancelar
    $('.CancelFancyBox').on('click',function(event){
			$.fancybox.close();
		});

    // Boton Guardar
    $('#frmNewEdit').submit(function(event){
      event.preventDefault();
  		//tinyMCE.triggerSave(); //save first tinymce en textarea
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
  });
</script>
