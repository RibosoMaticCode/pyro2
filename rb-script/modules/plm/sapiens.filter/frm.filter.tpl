<script src="{ruta_modulo}frm.filter.js"></script>
<div class="frmFiltro">
  <form id="frmData" class="form">
    <div class="CamposFiltro">
      <div>
        <label>
      	Universidad:
          <select name="univer" class="univer">
            <option value="0">Selecciona</option>
            <option value="UNT">UNT</option>
          </select>
        </label>
      </div>
      <div>
        <label>
        Tipo de libro:
          <select name="tipo_lib" class="tipo_lib">
            <option value="0">Selecciona</option>
            <option value="Vademecum">Vademécum</option>
            <option value="Banco de preguntas">Banco de preguntas</option>
          </select>
        </label>
      </div>
      <div>
        <label>
        Área:
          <select name="area" class="area">
            <option value="0">Selecciona</option>
            <option value="Ciencias">Ciencias</option>
            <option value="Letras">Letras</option>
          </select>
        </label>
      </div>
      <div>
        <button type="button" class="btnMostrar">Enviar</button>
      </div>
    </div>
  </form>
</div>