<div id="editor-items" class="editor-window">
	<div class="editor-header">
		<strong>Configuración del Item</strong>
	</div>
	<div class="editor-body">
    <form>
      <label>Titulo
        <input type="text" id="item_title" />
      </label>
      <div class="cols-container">
        <div class="cols-6-md">
          <label>Enlaza con:
            <select>
              <option>Categoría del Blog</option>
              <option>Publicación del Blog</option>
              <option>Página</option>
              <option>Personalizado</option>
            </select>
          </label>
        </div>
        <div class="cols-6-md">
          <label>Seleccionar elemento:
            <select>
              <option>[Seleccionar]</option>
            </select>
          </label>
        </div>
      </div>
      <label>Imagen a mostrar:
        <input type="text" id="item_img" />
      </label>
      <label>Sub Menu:
        <select>
          <option>[Seleccionar]</option>
        </select>
      </label>
    </form>
  </div>
  <div class="editor-footer">
		<button class="btn-primary" id="item_btnAccept">Cambiar</button>
		<button class="button" id="item_btnCancel">Cancelar</button>
	</div>
</div>
<script>
$(document).ready(function() {
  $('#item_btnCancel').click(function() {
    $('.bg-opacity, #editor-items').hide();
  });
});
</script>
