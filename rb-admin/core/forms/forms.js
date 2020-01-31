$(document).ready(function() {
    // SELECT ALL ITEMS CHECKBOXS
    $('#select_all').change(function(){
        var checkboxes = $(this).closest('table').find(':checkbox');
        if($(this).prop('checked')) {
          checkboxes.prop('checked', true);
        } else {
          checkboxes.prop('checked', false);
        }
    });
    // DELETE all
    $('#delete').click(function( event ){
      var len = $('input:checkbox[name=items]:checked').length;
      if(len==0){
        alert("[!] Seleccione un elemento a eliminar");
        return;
      }

      var eliminar = confirm("[?] Esta seguro de eliminar los "+len+ " items?");
      if ( eliminar ) {
        $('input:checkbox[name=items]:checked').each(function(){
          item_id = $(this).val();
          url = 'core/forms/forms.delete.php?id='+item_id;
          $.ajax({
            url: url,
            cache: false,
            type: "GET"
          }).done(function( data ) {
            if(data.result==0){
              notify('Ocurrio un error inesperado. Intente luego.');
              return false;
            }
          });
        });
        notify('Los datos seleccionados fueron eliminados correctamente.');
        setTimeout(function(){
          window.location.href = '<?= G_SERVER ?>rb-admin/module.php?pag=forms';
        }, 1000);
      }
    });
    // DELETE ITEM
    $('.del-item').click(function( event ){
      var item_id = $(this).attr('data-id');
      var eliminar = confirm("[?] Esta a punto de eliminar este dato. Continuar?");

      if ( eliminar ) {
        $.ajax({
          url: 'core/forms/forms.delete.php?id='+item_id,
          cache: false,
          type: "GET",
          success: function(data){
            if(data.result = 1){
              notify('El dato fue eliminado correctamente.');
              setTimeout(function(){
                window.location.href = '<?= G_SERVER ?>rb-admin/module.php?pag=forms';
              }, 1000);
            }else{
              notify('Ocurrio un error inesperado. Intente luego.');
            }
          }
        });
      }
    });

  // Guardar formulario
	$("#SaveForm").click(function (event) {
		event.preventDefault();
		tinyMCE.triggerSave();

		var fname = $('#form_name').val();
		var festr = $('#form_estructure').html();
		var fvalid = $('#form_validations').val();
		var fmode = $('#form_mode').val();
		var fmails = $('#form_mails').val();
		var fid = $('#form_id').val();
		var fintro = $('#form_intro').val();
		var frspta = $('#form_respuesta').val();

		$.ajax({
			url: "core/forms/forms.save.php",
			method: 'post',
			//data: $.param(data),
			data: 'name='+fname+'&estructure='+festr+'&validations='+fvalid+'&mode='+fmode+'&id='+fid+'&mails='+fmails+'&intro='+fintro+'&rspta='+frspta,
			beforeSend: function(){
				$('#img_loading, .bg-opacity').show();
			}
		})
		.done(function( data ) {
			if(data.result){
				$('#img_loading, .bg-opacity').hide();
				notify(data.message);
				if(fmode=="new"){
					setTimeout(function(){
						window.location.href = data.url+'rb-admin/forms/edit/'+data.last_id;
					}, 1000);
				}
			}else{
				notify(data.message);
				$('#img_loading, .bg-opacity').hide();
			}
		});
	});
});
