<div id="codeForm" class="editor-window">
	<div class="editor-header">
		<strong>Editor del codigo</strong>
	</div>
	<div class="editor-body">
    <textarea id="htmlraw_text_hidden" name="htmlraw_text_hidden" rows="5" style="display:none"></textarea>
    <div style="height:400px" id="htmlraw_text"></div>
  </div>
  <div class="editor-footer">
		<button class="button btn-primary" id="codeForm-btnaccept">Cambiar</button>
		<button class="button" id="codeForm-btncancel">Cancelar</button>
	</div>
</div>
<script src="https://ajaxorg.github.io/ace-builds/src-min/ace.js"></script>
<script>
    var editor1 = ace.edit("htmlraw_text");
    editor1.getSession().setMode("ace/mode/html");

    var textarea1 = $('textarea[name="htmlraw_text_hidden"]');
    editor1.getSession().on("change", function () {
        textarea1.val(editor1.getSession().getValue());
    });
</script>
<script>
$(function() {
  // Mostrar la ventana de configuracion
  $('.editCodeForm').click(function(event){
    event.preventDefault();
    $(".bg-opacity").show();
    $("#codeForm").show();

    var box_edit_html = $(".estructure_html");
    var content_to_edit = box_edit_html.html();
    editor1.setValue(content_to_edit.trim()); // Set values to ACE editor
    $('#htmlraw_text').val(content_to_edit);
  });
  //Aceptar cambios
  $('#codeForm-btnaccept').click(function() {
    $('.estructure_html').html($('#htmlraw_text_hidden').val());
    $('.bg-opacity, #codeForm').hide();
  });
  $('#codeForm-btncancel').click(function() {
    $('.bg-opacity, #codeForm').hide();
  });
});
</script>
