$(document).ready(function() {
  /**
   * Creates a string that can be used for dynamic id attributes
   * http://www.frontcoded.com/javascript-create-unique-ids.html
   * Example: "id-so7567s1pcpojemi"
   * @returns {string}
  */

  var uniqueId = function() {
    return Math.random().toString(36).substr(2, 16);
  };
  // jquery ui elementos que se pueden arrastrar y soltar
  $( "#boxes" ).sortable({
    placeholder: "placeholder",
    handle: ".box-header"
  });

  // Nuevo bloque, caja - box
  //var i=1;
  $('#boxNew').click( function( event ){
    event.preventDefault();
    //i++;
    $.ajax({
        url: "core/pages2/page-box-new.php?temp_id="+uniqueId()
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

  // ***** AÑADIR COLUMNAS ********

  // Añadir Columna para Slide
  //var j = 0;
  $("#boxes").on("click", ".addSlide", function (event) {
    event.preventDefault();
    var box_edit = $(this).closest(".item").find(".cols-html");
    var box_id = $(this).closest(".item").attr('data-id');
    //j++;
    $.ajax({
        url: "core/pages2/col-slide.php?temp_id="+box_id+"slide"+uniqueId()
    })
    .done(function( data ) {
      box_edit.append(data);
    });
  });

  // Añadir Columan para HTML
  //var k = 0
  $("#boxes").on("click", ".addHtml", function (event) {
    event.preventDefault();
    var box_edit = $(this).closest(".item").find(".cols-html");
    var box_id = $(this).closest(".item").attr('data-id');
    //k++;
    $.ajax({
        url: "core/pages2/col-html.php?temp_id="+box_id+"html"+uniqueId()
    })
    .done(function( data ) {
      box_edit.append(data);
    });
  });

  // Añadir Columan para Post1
  $("#boxes").on("click", ".addPost1", function (event) {
    event.preventDefault();
    var box_edit = $(this).closest(".item").find(".cols-html");
    var box_id = $(this).closest(".item").attr('data-id');
    //k++;
    $.ajax({
        //url: "core/pages2/col-post1.php?temp_id="+box_id+"html"+uniqueId()
        url: "core/pages2/col-post1.php?temp_id=post1"+uniqueId()
    })
    .done(function( data ) {
      box_edit.append(data);
    });
  });

  //*** EDITOR MODAL BOX ****

  // Mostrar Editor HTML
  $("#boxes").on("click", ".showEditHtml", function (event) {
    $(".bg-opacity").show();
    $("#editor-html").show();
    event.preventDefault();
    //Captura contenido
    var col_id = $(this).closest(".col").attr('id');

    var box_edit_html = $(this).closest(".col-box-edit").find(".box-edit-html");
    var content_to_edit = box_edit_html.html();
    var content_to_edit_id = box_edit_html.attr('id');
    //capturar nombre de clase
    //var css_class = $(this).closest(".col-box-edit").find(".css_class");
    //var css_class_val = css_class.val();
    //var css_class_id = css_class.attr('id');
    // Asignando valores
    //Id control a editar y asignar valor
    $('#control_edit_id').val(content_to_edit_id);
    tinymce.activeEditor.setContent(content_to_edit);

    // Capturando clase y asignando valor
    var css_class = $(this).closest(".col").attr('data-class');
    $('#control_id').val(col_id);
    $('#class_css').val(css_class);
  });

  // Mostrar Editor de Post1
  $("#boxes").on("click", ".showEditPost1", function (event) {
    var post1_id = $(this).closest(".col").attr('data-id');
    var post1_class = $(this).closest(".col").attr('data-class');
    var post1_values_string = $(this).closest(".col").attr('data-values');

    //post1_values_array === pva
    var pva = JSON.parse(post1_values_string);
    //console.log(pva.cat);

    $('#post1_id').val(post1_id);
    $('#post1_title').val(pva.tit);
    $('#post1_category').val(pva.cat);
    $('#post1_count').val(pva.count);
    $('#post1_order').val(pva.ord);
    $("input[name='post1_type'][value='"+pva.typ+"']").prop('checked', true);
    $('#post1_class').val(post1_class);

    $(".bg-opacity").show();
    $("#editor-post1").show();
    event.preventDefault();
  });

  // Mostrar Editor de Bloque
  $("#boxes").on("click", ".showEditBox", function (event) {
    var box_id = $(this).closest(".item").attr('data-id');
    //Bloque interno valores
    var boxin_height = $(this).closest(".item").attr('data-inheight');
    var boxin_width = $(this).closest(".item").attr('data-inwidth');
    var boxin_bgimage = $(this).closest(".item").attr('data-inbgimage');
    var boxin_bgcolor = $(this).closest(".item").attr('data-inbgcolor');
    var boxin_paddingtop = $(this).closest(".item").attr('data-inpaddingtop');
    var boxin_paddingright = $(this).closest(".item").attr('data-inpaddingright');
    var boxin_paddingbottom = $(this).closest(".item").attr('data-inpaddingbottom');
    var boxin_paddingleft = $(this).closest(".item").attr('data-inpaddingleft');
    var boxin_class = $(this).closest(".item").attr('data-inclass');
    //Bloque externos interno
    //var boxext_height = $(this).closest(".item").attr('data-extheight');
    //var boxext_width = $(this).closest(".item").attr('data-extwidth');
    var boxext_parallax = $(this).closest(".item").attr('data-extparallax');
    var boxext_bgimage = $(this).closest(".item").attr('data-extbgimage');
    var boxext_bgcolor = $(this).closest(".item").attr('data-extbgcolor');
    var boxext_paddingtop = $(this).closest(".item").attr('data-extpaddingtop');
    var boxext_paddingright = $(this).closest(".item").attr('data-extpaddingright');
    var boxext_paddingbottom = $(this).closest(".item").attr('data-extpaddingbottom');
    var boxext_paddingleft = $(this).closest(".item").attr('data-extpaddingleft');
    var boxext_class = $(this).closest(".item").attr('data-extclass');

    $('#eb_id').val(box_id);
    $('#boxin_height').val(boxin_height);
    $('#boxin_width').val(boxin_width);
    $('#boxin_bgimage').val(boxin_bgimage);
    $('#boxin_bgcolor').val(boxin_bgcolor);
    $('#boxin_paddingtop').val(boxin_paddingtop);
    $('#boxin_paddingright').val(boxin_paddingright);
    $('#boxin_paddingbottom').val(boxin_paddingbottom);
    $('#boxin_paddingleft').val(boxin_paddingleft);
    $('#boxin_class').val(boxin_class);

    //$('#boxext_height').val(boxext_height);
    //$('#boxext_width').val(boxext_width);
    $('#boxext_bgimage').val(boxext_bgimage);
    $('#boxext_bgcolor').val(boxext_bgcolor);
    $('#boxext_paddingtop').val(boxext_paddingtop);
    $('#boxext_paddingright').val(boxext_paddingright);
    $('#boxext_paddingbottom').val(boxext_paddingbottom);
    $('#boxext_paddingleft').val(boxext_paddingleft);
    $('#boxext_class').val(boxext_class);
    if(boxext_parallax==1){
      $('#boxext_parallax').prop('checked', true);
    }else{
      $('#boxext_parallax').prop('checked', false);
    }

    $(".bg-opacity").show();
    $("#editor-box").show();
    event.preventDefault();
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

  // ******* ENVIAR LOS DATOS PARA SER GUARDADOS ********
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
      var box_string_values_ext = ',"boxext_bgimage" : "'+$(elemento).attr('data-extbgimage')+'","boxext_bgcolor" : "'+$(elemento).attr('data-extbgcolor')+'","boxext_paddingtop" : "'+$(elemento).attr('data-extpaddingtop')+'","boxext_paddingright" : "'+$(elemento).attr('data-extpaddingright')+'","boxext_paddingbottom" : "'+$(elemento).attr('data-extpaddingbottom')+'","boxext_paddingleft" : "'+$(elemento).attr('data-extpaddingleft')+'","boxext_class" : "'+$(elemento).attr('data-extclass')+'","boxext_parallax" : "'+$(elemento).attr('data-extparallax')+'"';
      var box_string_values_in = ',"boxin_height" : "'+$(elemento).attr('data-inheight')+'","boxin_width" : "'+$(elemento).attr('data-inwidth')+'","boxin_bgimage" : "'+$(elemento).attr('data-inbgimage')+'","boxin_bgcolor" : "'+$(elemento).attr('data-inbgcolor')+'","boxin_paddingtop" : "'+$(elemento).attr('data-inpaddingtop')+'","boxin_paddingright" : "'+$(elemento).attr('data-inpaddingright')+'","boxin_paddingbottom" : "'+$(elemento).attr('data-inpaddingbottom')+'","boxin_paddingleft" : "'+$(elemento).attr('data-inpaddingleft')+'","boxin_class" : "'+$(elemento).attr('data-inclass')+'"';
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
        var col_css = $(elemento).attr('data-class'); //$('#class_'+col_id).val();// corregir de
        switch (col_type) {
          case 'html':
            htmlt_content_col = $(elemento).find('.box-edit-html').html();
            htmlt_content_col = encodeURIComponent(htmlEntities(htmlt_content_col)); //encodeURIComponent transforma los &amp en otras entidades
            col_values = "{}";
          break;
          case 'slide':
            htmlt_content_col = $(elemento).find('.slide_name').val();
            cols_values = "{}";
          break;
          case 'post1':
            col_values = $(elemento).attr('data-values');
            htmlt_content_col = "";
          break;
        }
        cols_string_content += coma + '{"col_id" : "'+$(elemento).attr('data-id')+'","col_content" : "'+htmlt_content_col+'","col_type":"'+ col_type + '", "col_css" : "'+ col_css +'","col_values": '+col_values+'}';
        coma = ",";
        j++;
      });
      cols_nums = ',"num_cols":"'+ j +'"}';
      all_columns_string += boxes_coma + box_string_init + box_string_values_ext + box_string_values_in + cols_string_start + cols_string_content + cols_string_end + cols_nums;
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
