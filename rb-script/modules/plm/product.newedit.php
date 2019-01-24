<?php
/*if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH.'rb-script/class/rb-database.class.php';*/
$urlreload=G_SERVER.'/rb-admin/module.php?pag=plm_products';
include_once ABSPATH.'rb-admin/tinymce/tinymce.mini.config.php';
$objDataBase = new Database;

if( isset($_GET['product_id']) ){
  $id=$_GET['product_id'];
  $q = $objDataBase->Ejecutar("SELECT * FROM plm_products WHERE id=$id");
  $row = $q->fetch_assoc();
}else{
  $id = 0;
}

$qo = $objDataBase->Ejecutar("SELECT * FROM plm_config WHERE plm_option='categorias'");
$option = $qo->fetch_assoc();
$categories = json_decode($option['plm_value'], true);
?>
<div class="inside_contenedor_frm">
  <div id="toolbar">
    <div class="inside_toolbar">
      <div class="navigation">
        <a href="#">Productos</a> <i class="fas fa-angle-right"></i> <span>Nuevo producto</span>
      </div>
    	<button type="submit">Guardar</button>
    	<a class="button" href="http://dev.pyro2/rb-admin/module.php?pag=plm_products">Volver</a>
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
      		          Nombre del producto
      		          <input type="text" name="nombre" required value="<?php if(isset($row)) echo $row['nombre'] ?>" />
      		        </label>
      			      <label>
      			         Descripción
      							 <textarea rows="25" id="editor1" name="descripcion" class="mceEditor" ><?php if(isset($row)) echo $row['descripcion'] ?></textarea>
      			       </label>
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
      								<label>
      				          Precio Normal
      				          <input type="number" step=".01" name="precio" required value="<?php if(isset($row)) echo $row['precio'] ?>" />
      				        </label>
      							</div>
      							<div class="cols-4-md">
      								<label title="Si establece este valor, el precio con descuento se autogenerara">
      				          Descuento
      				          <input type="number" name="descuento" value="<?php if(isset($row)) echo $row['descuento'] ?>" />
      				        </label>
      							</div>
      							<div class="cols-4-md">
      								<label title="Figurara como precio principal">
      				          Precio con Descuento
      				          <input type="number" step=".01" name="precio_oferta" value="<?php if(isset($row)) echo $row['precio_oferta'] ?>" />
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
                <?php
                $qc = $objDataBase->Ejecutar("SELECT * FROM plm_category ORDER BY nombre");
                while($category = $qc->fetch_assoc()){
                  ?>
                  <option value="<?= $category['id'] ?>" <?php if(isset($row) && $row['categoria']==$category['id']) echo "selected" ?>><?= $category['nombre'] ?></option>
                  <?php
                }
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
                  <input type="text" readonly name="foto_id" class="foto_id" value="<?php $photos = rb_get_photo_from_id( isset($row) ? $row['foto_id'] : 0 ); echo $photos['src']; ?>" />
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
      </div>
    </div>
  </form>
</div>
<script>
  $(document).ready(function() {
    // Boton Cancelar
    /*$('.CancelFancyBox').on('click',function(event){
      $.fancybox.close();
    });*/

    // Boton Guardar
    $('#frmproduct').submit(function(event){
      event.preventDefault();
      tinyMCE.triggerSave(); //save first tinymce en textarea
      $.ajax({
        method: "post",
        url: "<?= G_SERVER ?>/rb-script/modules/plm/product.save.php",
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
