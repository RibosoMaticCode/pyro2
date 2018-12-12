<?php if (!in_array("cat", $array_help_close)): ?>
<div class="help" data-name="cat">
  <h4>Información</h4>
  <p>Una <strong>Categoria</strong> permite agrupar las publicaciones.</p><p>Es importante que por lo menos haya una, pues no se podrá guardar una publicación sino hay una Categoría.</p>
</div>
<?php endif ?>
<script>
$(document).ready(function() {
  // DELETE ITEM
  $('.del-item').click(function( event ){
    var item_id = $(this).attr('data-id');
    var eliminar = confirm("[?] Esta a punto de eliminar la categoria (y subcategorias si las hubiera). Continuar?");

  	if ( eliminar ) {
  		$.ajax({
  			url: 'core/categories/category-del.php?id='+item_id,
  			cache: false,
  			type: "GET",
  			success: function(data){
          if(data.result = 1){
            notify('El dato fue eliminado correctamente.');
            setTimeout(function(){
              window.location.href = '<?= G_SERVER ?>/rb-admin/index.php?pag=cat';
            }, 1000);
          }else{
            notify('Ocurrio un error inesperado. Intente luego.');
          }
  			}
  		});
  	}
  });
});
</script>
<div class="wrap-content-list">
  <section class="seccion">
    <div class="seccion-header">
      <h2>Categorias</h2>
      <ul class="buttons">
        <li><a class="btn-primary" href="../rb-admin/?pag=cat&amp;opc=nvo"><i class="fa fa-plus-circle"></i> <span class="button-label">Nuevo</span></a></li>
      </ul>
    </div>
    <div class="seccion-body">
      <div id="content-list">
            <div id="resultado">
            <table id="t_categorias" class="tables">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Acceso</th>
                <th>Niveles</th>
                <th>Previo</th>
                <th colspan="2">Acciones</th>
              </tr>
             </thead>
            <tbody id="itemstable">
                <?php include('category-list.php') ?>
            </tbody>
            </table>
            </div>
        </div>
    </div>
  </section>
</div>
