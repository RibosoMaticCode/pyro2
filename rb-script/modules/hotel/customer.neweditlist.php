<div class="explorer" data-type="">
  <div class="explorer-header">
    <h3>Seleccionar cliente</h3>
    <a id="close" href="#">×</a>
  </div>
  <div class="explorer-body">
    <div class="tabs-container">
      <div class="tabs-buttons">
        <input id="tab1" type="radio" name="tabs" checked>
        <label for="tab1">Listado</label>

        <input id="tab2" type="radio" name="tabs">
        <label for="tab2">Registrar nuevo</label>
      </div>
      <div class="tabs-sections">
        <section id="tabcontent1">
          <?php
          $qlist = $objDataBase->Ejecutar("SELECT * FROM crm_customers ORDER BY id DESC");
          ?>
          <form class="form">
            <label>
              <input id="search_box" type="text" placeholder="Escriba para filtrar..." />
            </label>
          </form>
          <table id="table" class="tables fixed_headers table-striped">
            <thead>
              <tr>
                <th>Seleccionar</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Telefono</th>
                <th>Correo electronico</th>
              </tr>
            </thead>
            <tbody id="crm_list">
            </tbody>
          </table>
          <a class="button btn_select_customers" href="#">Aceptar cambios</a>
          <!--<a class="button btn_reset" href="#">Deseleccionar todo</a>-->
        </section>
        <section id="tabcontent2">
          <form id="frmcustomer" class="form" style="max-width:400px">
          	<input type="hidden" name="id" value="0" required />
            <label>
              Nombres *
              <input type="text" name="nombres" required value="" />
            </label>
            <label>
              Apellidos *
              <input type="text" name="apellidos" required value="" />
            </label>
            <label>
              Telefono
              <input type="tel" name="telefono" value="" />
            </label>
            <label>
              Correo
              <input type="email" name="correo" value="" />
            </label>
            <label>
              Direccion
              <input type="text" name="direccion" value="" />
            </label>
            <div class="cols-container">
              <div class="cols-6-md cols-content-left">
                <button class="button btn-primary" type="submit">Guardar</button>
              </div>
            </div>
          </form>

        </section>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    var type="various";
    // Cargar listado de clientes
    load_list_customers();

    // Boton Cancelar
    $('.CancelFancyBox').on('click',function(event){
      $.fancybox.close();
    });

    // Boton Guardar cliente express
    $('#frmcustomer').submit(function(event){
      event.preventDefault();
      type = $('.explorer').attr('data-type');
      $.ajax({
        method: "post",
        url: "<?= G_SERVER ?>rb-script/modules/crm/save.customer.php",
        data: $( this ).serialize()
      })
      .done(function( data ) {
        if(data.resultado){
          $.fancybox.close();
          notify(data.contenido);
          load_list_customers();
          $('#frmcustomer').trigger("reset");
          $('#tab1').click();
        }else{
          notify(data.contenido);
        }
      });

    });

    // Funcion cargar data de clientes
    function load_list_customers(){
      $("#search_box").val("");
      console.log("Llenando...");
      $('#crm_list').empty();
      var table_body = $('#crm_list');
      $.ajax({
        method: "get",
        dataType : 'json',
        url: "<?= G_SERVER ?>rb-script/modules/hotel/customer.list.json.php"
      })
      .done(function( data ) {
        result = JSON.parse("["+data+"]");
        console.log(result);
        $.each(result, function(i, item) {
          row = '<tr><td>';
          row += '<a href="#" class="crm_check_alone select_customer" data-id="'+item.id+'">Seleccionar</a>';
          row += '<input type="checkbox" class="crm_check" name="items" value="'+item.id+'" id="custom_'+item.id+'"  />'+
            '<label for="custom_'+item.id+'" class="crm_cover_check"></label>';
          row += '</td>'+
            '<td class="list_customer_name">'+item.nombres+'</td>'+
            '<td class="list_customer_lastname">'+item.apellidos+'</td>'+
            '<td>'+item.telefono+'</td>'+
            '<td>'+item.correo+'</td>'+
          '</tr>'
          $('#crm_list').append(row);
        });
        console.log(type);
        controles(type);
      });
    }

    // Click en item cliente
    $('#crm_list').on('click', '.select_customer', function(event){
      var nom = $(this).closest('tr').find('.list_customer_name').text();
      var ape = $(this).closest('tr').find('.list_customer_lastname').text();
      $('input[name=cliente_id]').val( $(this).attr('data-id') );
      $('input[name=cliente_name]').val(nom+" "+ape);
      $( "#close" ).click();
    });

    // CLick en varios items clientes
    $('#tabcontent1').on('click', '.btn_select_customers', function(event){
      var ids = "";
      var coma = "";
      var ocupantes_id = $('input[name=ocupantes_ids]').val();
      var array_ocupantes_id = ocupantes_id.split(",");
      if(ocupantes_id.length > 0){
        //ocupantes_id = ocupantes_id + ",";
        coma = ",";
      }
      console.log(array_ocupantes_id);
      $('input:checkbox[name=items]:checked').each(function(){
				item_id = $(this).val();
        if(array_ocupantes_id.includes(item_id)){
          return true;
        }
				ids += coma+item_id;
        coma = ",";
        var nom = $(this).closest('tr').find('.list_customer_name').text();
        var ape = $(this).closest('tr').find('.list_customer_lastname').text();
        $('#list_ocupantes').append($('<option>', {
          value: item_id,
          text: nom+" "+ape
        }));
			});
      console.log(ids);
      $('input[name=ocupantes_ids]').val(ocupantes_id+ids);
      $('input:checkbox[name=items]').removeAttr('checked');
      $( "#close" ).click();
    });

    // resetear items seleccionados

    // Filter customers
    /*$('#search_box').keyup(function(){
      var valThis = $(this).val();
      $('#crm_list>tr').each(function(){
        var text = $(this).find('td').text().trim().toLowerCase();
        console.log(text);
        (text.indexOf(valThis) == 0) ? $(this).show() : $(this).hide();
      });
    });*/
    $("#search_box").keyup(function(){ // https://gist.github.com/jerrac/4028731
      filter = new RegExp($(this).val(),'i');
		  $("#crm_list tr").filter(function(){
  			$(this).each(function(){
  				found = false;
  				$(this).children().each(function(){
  					content = $(this).html();
  					if(content.match(filter)){
  						found = true
  					}
  				});
  				if(!found){
  					$(this).hide();
  				}else{
  					$(this).show();
  				}
  			});
  		});
	  });

    // Cerrar ventana de explorer
    $( "#close" ).click(function( event ) {
      event.preventDefault();
      $("#search_box").val("").keyup();
      $('#tab1').click();
      $('#frmcustomer').trigger("reset");
      $(".bg-opacity").hide();
      $(".explorer").hide();
    });
  });
</script>
