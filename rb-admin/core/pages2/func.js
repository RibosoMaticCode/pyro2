$(document).ready(function() {
  // jquery ui elementos que se pueden arrastrar y soltar
  $( "#boxes" ).sortable({
    placeholder: "placeholder",
    handle: ".box-header"
  });
  var i=1;

  // click al llamar cada elemento para estructura de la web
  $('#boxSlide').click( function( event ){
    i++;
    $.ajax({
        url: "core/pages2/mod.design.blocks.php?t=slide&temp_id="+i
    })
    .done(function( data ) {
       $('#boxes').append( data );
    });
  });
  $('#boxGallery').click( function( event ){
    i++;
    $.ajax({
        url: "core/pages2/mod.design.blocks.php?t=gallery&temp_id="+i
    })
    .done(function( data ) {
       $('#boxes').append( data );
    });
  });
  $('#boxHtml').click( function( event ){
    i++;
    $.ajax({
        url: "core/pages2/mod.design.blocks.php?t=html&temp_id="+i
    })
    .done(function( data ) {
       $('#boxes').append( data );
    });
  });
  $('#boxPosts').click( function( event ){
    i++;
    $.ajax({
        url: "core/pages2/mod.design.blocks.php?t=posts&temp_id="+i
    })
    .done(function( data ) {
       $('#boxes').append( data );
    });
  });

  // Nuevo bloque, caja - box
  $('#boxNew').click( function( event ){
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
      var msg = confirm("¿Desea quitar?");
      if(msg){
        $(this).closest("li").remove();
      }
  });

  // agregar columna PROTOTIPO INICIAL
  /*$("#boxes").on("click", ".add-column", function (event) {
    var item = '<li class="col">'+
      '<span class="col-head">'+
        '<a class="close-column" href="#">X</a>'+
      '</span>'+
      '<div class="col-box-edit">'+
        '<div class="box-edit-options">'+
          '<a class="optSlide" href="#">Slides</a>'+
          '<a class="optHTML" href="#">HTML</a>'+
        '</div>'+
        '<div class="box-edit">'+
        '</div>'+
      '</div>'+
    '</li>';
    $(this).closest("li").find(".cols-html").append(item);
  });*/

  // Añadir Columna para Slide
  var j = 0;
  $("#boxes").on("click", ".addSlide", function (event) {
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
    event.preventDefault();
    var box_edit_html = $(this).closest(".col-box-edit").find(".box-edit-html");
    var content_to_edit = box_edit_html.html();
    var content_to_edit_id = box_edit_html.attr('id');

    //alert(content_to_edit);
    /*$.ajax({
        url: "core/pages2/html-edit.php?cte="+content_to_edit+"&cte_id="+content_to_edit_id
    })
    .done(function( data ) {
      $('.bg-opacity').show();
      $('.explorer').show();
      $('.explorer').append(data);
    });*/
    tinymce.activeEditor.setContent(content_to_edit);
    $('#control_id').val(content_to_edit_id);
  });
  /*
  $("#boxes").on("click", ".optSlide", function (event) {
    var box_edit_options = $(this).closest(".col-box-edit").find(".box-edit-options");
    var box_edit = $(this).closest(".col-box-edit").find(".box-edit");
    console.log('test');
    $.ajax({
        url: "core/pages2/box-slide.php"
    })
    .done(function( data ) {
      box_edit_options.slideUp();
      box_edit.append( data );
    });
  });

  // Click en Option Slide
  $("#boxes").on("click", ".optHTML", function (event) {
    var box_edit_options = $(this).closest(".col-box-edit").find(".box-edit-options");
    var box_edit = $(this).closest(".col-box-edit").find(".box-edit");
    console.log('test');
    $.ajax({
        url: "core/pages2/box-html.php"
    })
    .done(function( data ) {
      box_edit_options.slideUp();
      box_edit.append( data );
    });
  });*/

  // Remover columnas
  $("#boxes").on("click", ".close-column", function (event) {
    var msg = confirm("¿Desea quitar?");
      if(msg){
        $(this).closest("li").remove();
      }
  });

  // button hide/show
  $( ".arrow-up" ).hide();

  $("#boxes").on("click", ".toggle", function (event) {
    $(this).closest("li").find(".box-body").toggle();
    $(this).closest("li").find(".arrow-up, .arrow-down").toggle();
  });

  // Guardar cambios en diseñador
  $( "#btnGuardar" ).click(function() {
    var pagina_title = $('#titulo').val();

    var boxesmain_string_start = " {'boxes': [ ";
    var boxesmain_string_end = " ] ";
    //var boxes_string_content = "";
    var boxes_coma = "";
    var final_string_content = "";
    var i=0;
    var all_columns_string = "";

    // Revisando cada box - caja
    $('#boxes .item').each(function(indice, elemento) {
      var box_string_init = "{'box_id' : '"+$(elemento).attr('data-id')+"'";
      var cols_string_start = ", 'columns': [ ";
      var cols_string_end = " ] ";
      var cols_string_content = "";
      var coma = "";
      var j=0;

      var $this = $(this);
      // Revisando cada columna
      $this.find(".cols-html .col").each(function(indice, elemento) {

        var col_type = $(elemento).attr('data-type');
        switch (col_type) {
          case 'html':
            htmlt_content_col = $(elemento).find('.box-edit-html').html();
          break;
          case 'slide':
            htmlt_content_col = $(elemento).find('.slide_name').val();
          break;
        }
        cols_string_content += coma + "{'col_id' : '"+$(elemento).attr('data-id')+"' , 'col_content' : '"+htmlt_content_col+"' , 'col_type' : '" + col_type + "'}";
        coma = ",";
        j++;
      });
      cols_nums = ", 'num_cols' : '"+ j +"' }";
      all_columns_string += boxes_coma + box_string_init + cols_string_start + cols_string_content + cols_string_end + cols_nums;
      //console.log(string_data);
      boxes_coma = ",";
    });
    final_string_content += boxesmain_string_start + all_columns_string + boxesmain_string_end;
    console.log(JSON.stringify(final_string_content));

    $.ajax({
      url: "core/pages2/page.save.php?title="+pagina_title+"&content="+JSON.stringify(final_string_content),
      method: 'get'
    })
    .done(function( data ) {
      console.log(data);
    });
  });

// old - borrar
  $( "#_btnGuardar" ).click(function() {
    var pagina_id = 0;
    var pagina_title = $('#titulo').val();
    console.log( "Pagina Id:"+pagina_id );

    $.ajax({
      url: "page.save.php?title="+pagina_title
    })
    .done(function( data ) {
      if(data=="0"){
        console.log("Error al guardar la página");
        return;
      }else{
        var pagina_id = data;

        $('#boxes .item').each(function(indice, elemento) {
          console.log('Elemento: Position:'+indice+',Codigo:'+$(elemento).attr('id')+',Tipo:'+$(elemento).attr('data-type'));

          var string_data;

          var type = $(elemento).attr('data-type');
          /*switch(type){
            case 'slide':
              var gallery_id = $(elemento).find('.slide_name').val();
              string_data = "{'gallery_id':'"+gallery_id+"'}";

              $.ajax({
                  url: "design.save.php?pid="+pagina_id+"&tip="+type+"&pos="+indice+"&det="+string_data
              })
              .done(function( data ) {
                console.log( data );
              });
            break;
            case 'gallery':
              var gallery_id = $(elemento).find('.gallery_name').val();
              var gallery_show = $(elemento).find('.gallery_show').val();
              var gallery_byrow = $(elemento).find('.gallery_byrow').val();

              string_data = "{'gallery_id':'"+gallery_id+"', 'gallery_show' : '"+gallery_show+"', 'gallery_byrow' : '"+gallery_byrow+"'}";

              $.ajax({
                  url: "design.save.php?pid="+pagina_id+"&tip="+type+"&pos="+indice+"&det="+string_data
              })
              .done(function( data ) {
                console.log( data );
              });
            break;
            case 'html':
              var html_string_start = " {'columns': [ ";
              var html_string_end = " ] ";
              var html_string_content = "";
              var coma = "";
              var j=0;

              $('.cols-html li').each(function(indice, elemento) {
                console.log( 'Columna: Position:'+indice+',Contenido:'+$(elemento).find('.col-content').val() );
                htmlt_content_col = $(elemento).find('.col-content').val();

                html_string_content += coma + "{'html_id' : '"+indice+"' , 'html_content' : '"+htmlt_content_col+"'}";
                coma = ",";
                j++;
              });
              html_num_cols = ", 'num_cols' : '"+ j +"' }";

              string_data = html_string_start + html_string_content + html_string_end + html_num_cols;

              $.ajax({
                  url: "design.save.php?pid="+pagina_id+"&tip="+type+"&pos="+indice+"&det="+string_data
              })
              .done(function( data ) {
                console.log( data );
              });
              //console.log( html_string_all );
            break;
            case 'posts':
              var category_id = $(elemento).find('.category_name').val();
              var category_show = $(elemento).find('.category_show').val();
              var category_byrow = $(elemento).find('.category_byrow').val();

              if( $(elemento).find('.category_list').is( ":checked" ) ){
                var category_style = "list";
              }
              if( $(elemento).find('.category_grid').is( ":checked" ) ){
                var category_style = "grid";
              }

              string_data = "{'category_id':'"+category_id+"', 'category_show' : '"+category_show+"', 'category_byrow' : '"+category_byrow+"', 'category_style' : '"+category_style+"'}";

              $.ajax({
                  url: "design.save.php?pid="+pagina_id+"&tip="+type+"&pos="+indice+"&det="+string_data
              })
              .done(function( data ) {
                console.log( data );
              });
            break;
          }*/
        });
      }
    });
  });
});
