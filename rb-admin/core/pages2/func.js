$(document).ready(function() {
  // jquery ui elementos que se pueden arrastrar y soltar
  $( "#boxes" ).sortable({
    placeholder: "placeholder",
    handle: ".box-header"
  });
  var i=1;

  // Nuevo bloque, caja - box
  $('#boxNew').click( function( event ){
    event.preventDefault();
    i++;
    $.ajax({
        url: "core/pages2/page-box-new.php?temp_id="+i
    })
    .done(function( data ) {
       $('#boxes').append( data );
    });
  });

  // borrar cada bloque
  $("#boxes").on("click", ".boxdelete", function (event) {
    event.preventDefault();
    var msg = confirm("¿Desea quitar?");
    if(msg){
      $(this).closest("li").remove();
    }
  });

  // Añadir Columna para Slide
  var j = 0;
  $("#boxes").on("click", ".addSlide", function (event) {
    event.preventDefault();
    var box_edit = $(this).closest(".item").find(".cols-html");
    var box_id = $(this).closest(".item").attr('data-id');
    j++;
    $.ajax({
        url: "core/pages2/col-slide.php?temp_id="+box_id+"slide"+j
    })
    .done(function( data ) {
      box_edit.append(data);
    });
  });

  // Añadir Columan para HTML
  var k = 0;
  $("#boxes").on("click", ".addHtml", function (event) {
    event.preventDefault();
    var box_edit = $(this).closest(".item").find(".cols-html");
    var box_id = $(this).closest(".item").attr('data-id');
    k++;
    $.ajax({
        url: "core/pages2/col-html.php?temp_id="+box_id+"html"+k
    })
    .done(function( data ) {
      box_edit.append(data);
    });
  });

  // Mostrar Editor HTML
  $("#boxes").on("click", ".showEditHtml", function (event) {
    $(".bg-opacity").show();
    $(".editor-html").show();
    event.preventDefault();
    var box_edit_html = $(this).closest(".col-box-edit").find(".box-edit-html");
    var content_to_edit = box_edit_html.html();
    var content_to_edit_id = box_edit_html.attr('id');
    tinymce.activeEditor.setContent(content_to_edit);
    $('#control_id').val(content_to_edit_id);
  });

  // Remover columnas
  $("#boxes").on("click", ".close-column", function (event) {
    event.preventDefault();
    var msg = confirm("¿Desea quitar?");
      if(msg){
        $(this).closest("li").remove();
      }
  });

  // button hide/show
  $( ".arrow-up" ).hide();
  $("#boxes").on("click", ".toggle", function (event) {
    event.preventDefault();
    $(this).closest("li").find(".box-body").toggle();
    $(this).closest("li").find(".arrow-up, .arrow-down").toggle();
  });

  // Guardar cambios en diseñador
  function htmlEntities(str) {
    // Remplaza codigo HTML con otras entidades (Como: &, <, >, ", espacio en blancos, ')
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/\n|\r/g, "").replace(/'/g, '&#39;');
  }

  $( "#btnGuardar" ).click(function() {
    event.preventDefault();
    var pagina_title = $('#titulo').val();
    var pagina_id = $('#pagina_id').val();
    var menu_id = $('select[name=menu]').val()
    var mode = $('#mode').val();

    if(pagina_title == "" ){
      notify('Escriba el titulo de la página');
      $('#titulo').focus();
      return false;
    }
    var boxesmain_string_start = '{"boxes": [';
    var boxesmain_string_end = ']}';
    var boxes_coma = '';
    var final_string_content = '';
    var i=0;
    var all_columns_string = '';

    // Revisando cada box - caja
    $('#boxes .item').each(function(indice, elemento) {
      var box_string_init = '{"box_id" : "'+$(elemento).attr('data-id')+'"';
      var cols_string_start = ',"columns":[';
      var cols_string_end = ']';
      var cols_string_content = '';
      var coma = '';
      var j=0;

      var $this = $(this);
      // Revisando cada columna
      $this.find(".cols-html .col").each(function(indice, elemento) {
        var col_id = $(elemento).attr('data-id');
        var col_type = $(elemento).attr('data-type');
        var col_css = $('#class_'+col_id).val();
        switch (col_type) {
          case 'html':
            htmlt_content_col = $(elemento).find('.box-edit-html').html();
            htmlt_content_col = encodeURIComponent(htmlEntities(htmlt_content_col)); //encodeURIComponent transforma los &amp en otras entidades
          break;
          case 'slide':
            htmlt_content_col = $(elemento).find('.slide_name').val();
          break;
        }
        cols_string_content += coma + '{"col_id" : "'+$(elemento).attr('data-id')+'","col_content" : "'+htmlt_content_col+'","col_type":"'+ col_type + '", "col_css" : "'+ col_css +'"}';
        coma = ",";
        j++;
      });
      cols_nums = ',"num_cols":"'+ j +'"}';
      all_columns_string += boxes_coma + box_string_init + cols_string_start + cols_string_content + cols_string_end + cols_nums;
      //console.log(string_data);
      boxes_coma = ",";
    });
    final_string_content += boxesmain_string_start + all_columns_string + boxesmain_string_end;
    console.log(final_string_content); // no es necesario pasar a json en js antes JSON.stringify

    $.ajax({
      url: "core/pages2/page.save.php",
      method: 'post',
      data: "title="+pagina_title+"&content="+final_string_content+"&pid="+pagina_id+"&mode="+mode+"&menu_id="+menu_id
    })
    .done(function( data ) {
      if(data.resultado=="ok"){
        notify("La página se guardo en la base de datos");
        setTimeout(function(){
          window.location.href = data.url+'/rb-admin/index.php?pag=pages&opc=edt&id='+data.last_id;
        }, 1000);
      }else{
        notify("Existe un error al intentar guardar en la base de datos");
        console.log(data.contenido);
      }
    });
  });
});
