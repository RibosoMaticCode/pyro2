<!-- FORMULARIO DE CONFIGURACION DEL WIDGET -->
<?php
$widget_id = "addPlmUrl";
$type = "plm_url";
$action = "showConfigPlmUrl";
$frm_config_id = "plm_widget_url";
$btnAccept = $type."_accept";
$btnCancel = $type."_cancel";
?>
<div id="<?= $frm_config_id ?>" class="editor-window">
	<div class="editor-header">
		<strong>Configuración del widget URL</strong>
	</div>
	<div class="editor-body">
		<div class="cols-container form">
			<div class="cols-6-md spacing-right">
				<label>Class CSS
					<input type="text" name="class_css" />
				</label>
			</div>
			<div class="cols-6-md spacing-left">
			</div>
		</div>
		<div id="ta">
		  <p>Editor de html</p>
		</div>
	</div>
	<div class="editor-footer">
		<button class="btn-primary" id="<?= $btnAccept ?>">Cambiar</button>
		<button class="button" id="<?= $btnCancel ?>">Cancelar</button>
	</div>
	<script>
	$(function() {
    // Mostrar el Widget
    $("html").on("click", ".<?= $widget_id ?>", function (event) {
      event.preventDefault();
      var widgets = $(this).closest(".widgets");
      var widget_id = "widget"+uniqueId();
      $.ajax({
          url: "<?= G_SERVER ?>/rb-script/modules/plm/widget.url.php?temp_id="+widget_id
      })
      .done(function( data ) {
        notify("Elemento añadido");
        widgets.append(data);
      });
    });

		// Mostrar Configurador de Widget
		$("#boxes").on("click", ".<?= $action ?>", function (event) {
	    $(".bg-opacity").show();
	    $("#<?= $frm_config_id ?>").show();
	  });

		// Enviando los valores
	  $('#<?= $btnAccept ?>').click(function() {
			$('.bg-opacity, #<?= $frm_config_id ?>').hide();
	  });

		$('#<?= $btnCancel ?>').click(function() {
			$('.bg-opacity, #<?= $frm_config_id ?>').hide();
	  });
	});
	</script>
</div>
