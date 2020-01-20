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
    event.preventDefault();
		var len = $('input:checkbox[name=items]:checked').length;
		if(len==0){
			alert("[!] Seleccione un elemento a eliminar");
			return;
		}

    var url;
		var eliminar = confirm("[?] Esta seguro de eliminar los "+len+ " items?");
		if ( eliminar ) {
			$('input:checkbox[name=items]:checked').each(function(){
				item_id = $(this).val();
        var item_li = $(this).closest('li');
        console.log(item_li);
				url = 'core/files/file-del.php?id='+item_id;
				$.ajax({
					url: url,
					cache: false,
					type: "GET"
				}).done(function( data ) {
          if(data.result){
            item_li.fadeOut();
          }else{
            notify('Ocurrio un error inesperado. Intente luego.');
            return false;
          }
        });
			});
      notify('Los datos seleccionados fueron eliminados correctamente.');
		}
	});
  
  // DELETE ITEM
  $('#grid').on('click', '.del-item', function( event ){
    event.preventDefault();

    var item_id = $(this).attr('data-id');
    item_li = $(this).closest('li');
    var eliminar = confirm("[?] Esta a punto de eliminar este dato. Continuar?");

  	if ( eliminar ) {
  		$.ajax({
  			url: 'core/files/file-del.php?id='+item_id,
  			cache: false,
  			type: "GET",
  			success: function(data){
          //console.log(data);
          if(data.result){
            notify('El dato fue eliminado correctamente.');
            item_li.fadeOut();
          }
          if(!data.result){
            notify('Error: '+data.message+'<br />Detalles: '+data.detail, 4000);
          }
  			}
  		});
  	}
  });

  // show uploader
  $('.show-uploader').click(function( event ){
    $('#uploader').slideToggle();
  });

  // Filter files
  $('#search_box').keyup(function(){
    var valThis = $(this).val();
    $('.gallery>li').each(function(){
      var text = $(this).find('.filename').text().trim().toLowerCase();
      (text.indexOf(valThis) == 0) ? $(this).show() : $(this).hide();
    });
  });
});
