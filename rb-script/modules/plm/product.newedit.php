<?php
/*if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH.'rb-script/class/rb-database.class.php';*/
require_once "funcs.php";
$urlreload=G_SERVER.'rb-admin/module.php?pag=plm_products';
include_once ABSPATH.'rb-admin/tinymce/tinymce.config.php';
$objDataBase = new Database;

if( isset($_GET['product_id']) ){
  $id=$_GET['product_id'];
  $q = $objDataBase->Ejecutar("SELECT * FROM plm_products WHERE id=$id");
  $row = $q->fetch_assoc();
}else{
  $id = 0;
}

/*$qo = $objDataBase->Ejecutar("SELECT * FROM plm_config WHERE plm_option='categorias'");
$option = $qo->fetch_assoc();
$categories = json_decode($option['plm_value'], true);*/
?>
<div class="inside_contenedor_frm">
  <div id="toolbar">
    <div class="inside_toolbar">
      <div class="navigation">
        <a href="<?= G_SERVER ?>rb-admin/module.php?pag=plm_products">Productos</a> <i class="fas fa-angle-right"></i>
        <?php if(isset($row)): ?>
          <?= rb_fragment_letters($row['nombre'], 40) ?>
        <?php else: ?>
          <span>Nuevo producto</span>
        <?php endif ?>
      </div>
    	<button class="button btn-primary" type="submit" form="frmproduct">Guardar</button>
    	<a class="button" href="<?= G_SERVER ?>rb-admin/module.php?pag=plm_products">Volver</a>
    </div>
  </div>
  <form id="frmproduct" class="form">
    <div class="cols-container">
      <div class="cols-8-md col-padding-right">
        <section class="seccion">
        	<div class="seccion-header">
        		<h3>Informacion del producto</h3>
        	</div>
        	<div class="seccion-body">
      		        <input type="hidden" name="id" value="<?= $id ?>" required />
      		        <label>
      		          Nombre del producto *
      		          <input type="text" name="nombre" required value="<?php if(isset($row)) echo $row['nombre'] ?>" />
      		        </label>
                  <label>
                    Nombre largo del producto
                    <span class="info">Este se mostrará en la página individual del producto</span>
                    <input type="text" name="nombre_largo" value="<?php if(isset($row)) echo $row['nombre_largo'] ?>" />
                  </label>
      			      <label>
      			         Descripción
      							 <textarea rows="25" id="editor1" name="descripcion" class="mceEditor" ><?php if(isset($row)) echo $row['descripcion'] ?></textarea>
      			       </label>
          </div>
        </section>

        <section class="seccion">
          <div class="seccion-header">
            <h3>Formato</h3>
          </div>
          <div class="seccion-body">
            <label>
              <input type="checkbox" name="formato_fisico" <?php if(isset($row) && $row['formato_fisico']==1) print "checked" ?> /> Físico
            </label>
            <label>
              <input type="checkbox" name="formato_digital" <?php if(isset($row) && $row['formato_digital']==1) print "checked" ?> /> Digital <br />
              URL de producto digital
              <input type="text" name="url_archivo" placeholder="https://" value="<?php if(isset($row)) print $row['url_archivo'] ?>" />
            </label>
          </div>
        </section>

        <section class="seccion">
          <div class="seccion-header">
            <h3>Detalles adicionales</h3>
          </div>
          <div class="seccion-body">
      						<div class="cols-container">
      							<div class="cols-6-md">
      								<label>
      				          Marca
      				          <input type="text" name="marca" value="<?php if(isset($row)) echo $row['marca'] ?>" />
      				        </label>
      							</div>
      							<div class="cols-6-md">
      								<label>
      				          Modelo
      				          <input type="text" name="modelo" value="<?php if(isset($row)) echo $row['modelo'] ?>" />
      				        </label>
      							</div>
      						</div>
      						<div class="cols-container">
      							<div class="cols-4-md">
      								<label title="Si existe variantes de productos. El precio sera determinado por las variantes.">
      				          Precio Normal
      				          <input type="number" step=".01" name="precio" required value="<?php if(isset($row)) echo $row['precio']; else echo '0'; ?>" />
      				        </label>
      							</div>
      							<div class="cols-4-md">
      								<label title="Si establece este valor, el precio con descuento se autogenerara. Se aplica tambien a las variantes de productos.">
      				          Descuento
      				          <input type="number" name="descuento" value="<?php if(isset($row)) echo $row['descuento'] ?>" />
      				        </label>
      							</div>
      							<div class="cols-4-md">
      								<label title="Este valor se autogenera, cuando se establece el porcentaje de descuento">
      				          Precio con Descuento
      				          <input type="number" readonly step=".01" name="precio_oferta" value="<?php if(isset($row)) echo $row['precio_oferta'] ?>" />
      				        </label>
      							</div>
      						</div>
      						<div class="cols-container">
      							<div class="cols-6-md">
      								<label>
      				          Tipo envio
      				          <input type="text" name="tipo_envio" value="<?php if(isset($row)) echo $row['tipo_envio'] ?>" placeholder="A domicilio/ Recogo en tienda/ Coordinacion telefonica" />
      				        </label>
      							</div>
      							<div class="cols-6-md">
      								<label>
      				          Tiempo aproximado de entrega (días)
      				          <input type="number" name="tiempo_envio" value="<?php if(isset($row)) echo $row['tiempo_envio'] ?>" />
      				        </label>
      							</div>
      						</div>
      						<div class="cols-container">
      							<div class="cols-6-md">
      								<label>
      									Estado
      									<select name="estado">
      										<option value="1" <?php if(isset($row) && $row['estado']==1) echo "selected" ?>>En stock</option>
      										<option value="0" <?php if(isset($row) && $row['estado']==0) echo "selected" ?>>Agotado</option>
      									</select>
      								</label>
      							</div>
      							<div class="cols-6-md">
      								<label title="Stock Keeping Unit, codigo unico">
      				          SKU
      				          <input type="text" name="sku" value="<?php if(isset($row)) echo $row['sku'] ?>" />
      				        </label>
      							</div>
      						</div>
        	</div>
        </section>
        <section class="seccion">
        	<div class="seccion-header">
        		<h3>Variantes de producto</h3>
        	</div>
          <div class="seccion-body">
            <div clas="tabs-container">
              <div class="tabs-buttons">
                <input id="tab1" type="radio" name="tabs" checked />
                <label for="tab1">Variantes</label>
                <input id="tab2" type="radio" name="tabs" />
                <label for="tab2">Atributos</label>
              </div>
              <div class="tabs-sections">
                <section id="tabcontent1">
                  <div class="cols-container variants_header">
                    <div class="cols-4-md">
                      Variante
                    </div>
                    <div class="cols-2-md">
                      Precio
                    </div>
                    <div class="cols-2-md">
                      Estado
                    </div>
                    <div class="cols-2-md">
                      Visible
                    </div>
                    <div class="cols-2-md">
                      <a title="Crear / Ver galerias" target="_blank" href="<?= G_SERVER ?>rb-admin/index.php?pag=explorer">Imagen ID</a>
                    </div>
                  </div>
                  <div id="wrap_variants">
                    <?php
                    if(isset($row)){
                      $qv = $objDataBase->Ejecutar("SELECT * FROM plm_products_variants WHERE product_id =".$row['id']);
                      if($qv->num_rows > 0) {
                        while($variant = $qv->fetch_assoc()){
                          ?>
                          <div class="cols-container" id="<?= preg_replace('/[^a-zA-Z0-9]/', '', $variant['name']) ?>">
                            <div class="cols-4-md">
                              <input type="text" class="variant_name" readonly name="variant_name[]" value="<?= $variant['name'] ?>" />
                            </div>
                            <div class="cols-2-md">
                              <input type="text" class="variant_price" name="variant_price[]" value="<?= $variant['price'] ?>" />
                            </div>
                            <div class="cols-2-md">
                              <select class="variant_state" name="variant_state[]">
                                <option value="1" <?php if($variant['state']==1) echo "selected" ?>>Stock</option>
                                <option value="0" <?php if($variant['state']==0) echo "selected" ?>>Agotado</option>
                              </select>
                            </div>
                            <div class="cols-2-md">
                              <select class="variant_visible" name="variant_visible[]">
                                <option value="1" <?php if($variant['visible']==1) echo "selected" ?>>Si</option>
                                <option value="0" <?php if($variant['visible']==0) echo "selected" ?>>No</option>
                              </select>
                            </div>
                            <div class="cols-2-md">
                              <input type="text" class="variant_gallery_id" name="variant_gallery_id[]" value="<?= $variant['image_id']?>" />
                            </div>
                          </div>
                          <?php
                        }
                      }
                    }
                    ?>
                  </div>
                  <input type="hidden" name="opciones" value='<?php if(isset($row)) echo $row['options'] ?>' />
                  <input type="hidden" name="array_combos" value='<?php if(isset($row)) echo $row['options_variants'] ?>' />
                </section>
                <section id="tabcontent2">
                  <div id="wrap_options" class="wrap_options">
                    <?php
                    if(isset($row)){
                      if($qv->num_rows > 0) {
                        $array_combos = json_decode($row['options_variants'], true);
                        foreach ($array_combos as $atributo => $alternativas) {
                          ?>
                          <div class="cover_option cols-container">
                            <div class="cols-3-md">
                              <label>
                                Opcion <em>Ej. Color, Tamaño</em>
                                <input class="nombre" type="text" name="opcion_nombre[]" value="<?= $atributo ?>" />
                              </label>
                            </div>
                            <div class="cols-8-md">
                              <label>
                                Alternativas <em>Ej. Rojo, Amarillo, Pequeño, Mediano</em>
                                <input class="alternativas" type="text" name="opcion_alternativas[]" value="<?= implode(",", $alternativas) ?>" />
                              </label>
                            </div>
                            <div class="cols-1-md remove_cover">
                              <a class="remove_item" href="#"><i class="fa fa-times"></i></a>
                            </div>
                          </div>
                          <?php
                        }
                      }
                    }
                    ?>
                  </div>
                  <div class="cols-container">
                    <div class="cols-6-md">
                      <a href="#" class="add_item">Añadir opcion</a>
                    </div>
                    <div class="cols-6-md cols-content-right">
                      <a href="#" class="edit_variants">Generar las variantes</a>
                    </div>
                  </div>
                </section>
              </div>
            </div>
          </div>
        </section>
      </div>
      <div class="cols-4-md col-padding-left">
        <section class="seccion">
          <div class="seccion-header">
            <h3>Categoria</h3>
          </div>
          <div class="seccion-body">
            <label>
              Categoria
              <select name="categoria">
                <option value="0">Seleccione una, sino existe creela</option>
                <?php
                if(isset($row)):
                  $selected_id = $row['categoria'];
                else:
                  $selected_id = 0;
                endif;

                $categorias = list_category(0);
                $nivel = 0;
                function show_categories_list($categorias,$nivel, $selected_id){
                  //$newedit_path = G_DIR_MODULES_URL."plm/category.newedit.php";
                  foreach ($categorias as $categoria) {
                    ?>
                    <option value="<?= $categoria['id'] ?>" <?php if($categoria['id']==$selected_id) echo "selected" ?>><?php echo str_repeat("-", $nivel) ?> <?= $categoria['nombre'] ?></option>
                    <?php
                    if(isset($categoria['items'])){
                      show_categories_list($categoria['items'], $nivel+1, $selected_id);
                    }
                  }
                }

                show_categories_list($categorias, $nivel, $selected_id);
                ?>
              </select>
            </label>
          </div>
        </section>
        <section class="seccion">
          <div class="seccion-header">
            <h3>Imágenes</h3>
          </div>
          <div class="seccion-body">
            <label>
              Imagen del producto
              <script>
                $(document).ready(function() {
                  $(".foto_id").filexplorer({
                    inputHideValue: "<?php if(isset($row)) echo $row['foto_id']; else echo "0"; ?>"
                  });
                });
              </script>
              <?php
              $photo_product = "";
              if( isset($row) ){
                $Photo = rb_get_photo_details_from_id( $row['foto_id'] );
                $photo_product = $Photo['file_name'];
              }
              ?>
              <input type="text" readonly name="foto_id" class="foto_id" value="<?= $photo_product ?>" />
            </label>
            <label>
              Galeria de imagenes
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
          </div>
        </section>
        <?php //include_once 'sapiens.filter/form.edit.fields.adds.php' ?>
      </div>
    </div>
  </form>
</div>
<script>
  $(document).ready(function() {
    // Add element to grupo
    $('.add_item').on('click',function(event){
      event.preventDefault();
      $.ajax({
  			method: "get",
  			url: "<?= G_SERVER ?>rb-script/modules/plm/newoption.html"
  		})
  		.done(function( data ) {
  			$('.wrap_options').append(data);
  		});
    });

    // Quitar element del grupo
    $("#wrap_options").on("click", ".remove_item", function (event) {
      event.preventDefault();
		  $(this).closest(".cover_option").fadeOut().remove();
    });

    // Generar variantes
    $('.edit_variants').on('click',function(event){
      event.preventDefault();

      // Capturar valores de Atributos: Opciones y sus Alternativas
      var nodes = Array.prototype.slice.call( document.getElementById('wrap_options').children );
      var numItems = nodes.length;
      if(numItems==0){
        alert("No hay valores para generar");
      }
      var arrays = {};
      var array_opcion = [];
      var arraysPHP = {};

      for (var i = 0; i <= numItems-1; i++) {
        var cover1 = nodes[i].getElementsByClassName("cols-3-md");
        var opcion_nombre = cover1.item(0).getElementsByTagName("input").item(0).value; // Nombre de la Opcion
        if(opcion_nombre === ""){
          alert("Ingrese un valor en Opcion");
          return false;
        }
        array_opcion.push(opcion_nombre.trim());

        var cover2 = nodes[i].getElementsByClassName("cols-8-md");
        var opcion_alternativas = cover2.item(0).getElementsByTagName("input").item(0).value; // Alternativas
        if(opcion_alternativas === ""){
          alert("Ingrese un valores para las Alternativas");
          return false;
        }
        array_alternativas = opcion_alternativas.split(",").map(function(item) { //https://stackoverflow.com/questions/7695997/split-the-sentences-by-and-remove-surrounding-spaces
          return item.trim(); // remover espacios en blanco en el item
        });
        console.log(array_alternativas);
        if(array_alternativas.includes("")){
          alert("Exiten elementos vacios. Corriga eso!");
          return false;
        }
        alternativa = {};
        duplicates = find_duplicate_in_array(array_alternativas);
        if(duplicates.length>0){
          alert("Hay elementos duplicados en las alternativas, corriga eso!");
          return false;
        }
        for (x=0;x<array_alternativas.length;x++){
          alternativa[x] = array_alternativas[x];
        }
        arrays[i] = alternativa;
        arraysPHP[opcion_nombre] = alternativa;
      }
      //console.log(arraysPHP);
      console.log(JSON.stringify(arrays));

      $('input[name=opciones]').val(JSON.stringify(array_opcion));
      $('input[name=array_combos]').val(JSON.stringify(arraysPHP));

      // Capturar opciones que hayan sido creados previamente.
      var variants = {};

      //var i=0;
      $("#wrap_variants .cols-container").each(function(index, element) {
        /*console.log(this);
        console.log(element);*/
				vname = $(element).find(".variant_name").val();
        vprice = $(element).find(".variant_price").val();
        vstate = $(element).find(".variant_state").val();
        vvisible = $(element).find(".variant_visible").val();
        vgallery_id = $(element).find(".variant_gallery_id").val();

        var variante = {};
        variante['name'] = vname;
        variante['price'] = vprice;
        variante['state'] = vstate;
        variante['visible'] = vvisible;
        variante['gallery_id'] = vgallery_id;

        variants[index] = variante;
			});

      console.log(JSON.stringify(variants));

      // Enviamos al generador de combos
      $.ajax({
        method: "get",
        url: "<?= G_SERVER ?>rb-script/modules/plm/variants.php?array="+JSON.stringify(arrays)+"&array_prev="+JSON.stringify(variants),
      })
      .done(function( data ) {
        // resultado
        if(data['result']==false){
          alert(data['message']);
        }else{
          // Añadir nuevos
          var size = Object.keys(data['nuevos']).length;
          for (var i = 0; i < size; i++) {
            //console.log(data.nuevos[i]);
            $('#wrap_variants').append('<div class="cols-container" id="'+data['nuevos'][i].replace(/[^a-z0-9]/gi,'')+'">'+
              '<div class="cols-4-md">'+
                '<input type="text" class="variant_name" readonly name="variant_name[]" value="'+data['nuevos'][i]+'" />'+
              '</div>'+
              '<div class="cols-2-md">'+
                '<input type="text" name="variant_price[]" />'+
              '</div>'+
              '<div class="cols-2-md">'+
                '<select class="variant_state" name="variant_state[]">'+
                  '<option value="1">Stock</option>'+
                  '<option value="0">Agotado</option>'+
                '</select>'+
              '</div>'+
              '<div class="cols-2-md">'+
                '<select class="variant_visible" name="variant_visible[]">'+
                  '<option value="1">Si</option>'+
                  '<option value="0">No</option>'+
                '</select>'+
              '</div>'+
              '<div class="cols-2-md">'+
                '<input class="variant_gallery_id" type="text" name="variant_gallery_id[]" />'+
              '</div>'+
            '</div>');
          }
          // Retirar
          var size = Object.keys(data['eliminar']).length;
          for (var i = 0; i < size; i++) {
            console.log(data.eliminar[i]);
            $('#'+data.eliminar[i]).remove();
          }
          $('#tab1').click();
        }
      });
    });

    function find_duplicate_in_array(arra1) {
        var object = {};
        var result = [];

        arra1.forEach(function (item) {
          if(!object[item])
              object[item] = 0;
            object[item] += 1;
        })

        for (var prop in object) {
           if(object[prop] >= 2) {
               result.push(prop);
           }
        }

        return result;

    }

    // Boton Guardar
    $('#frmproduct').submit(function(event){
      event.preventDefault();
      tinyMCE.triggerSave(); //save first tinymce en textarea
      $.ajax({
        method: "post",
        url: "<?= G_SERVER ?>rb-script/modules/plm/product.save.php",
        data: $( this ).serialize()
      })
      .done(function( data ) {
        if(data.resultado){
          $.fancybox.close();
          notify(data.contenido);
          setTimeout(function(){
            window.location.href = '<?= $urlreload ?>&product_id='+data.id;
          }, 1000);
        }else{
          notify(data.contenido);
        }
      });
    });
  });
</script>
