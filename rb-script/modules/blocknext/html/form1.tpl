<div class="block_steps">
  <form id="block_data" class="form">
    <div id="step1" class="step">
      <label>
        Nombres *:
        <input type="text" id="getName" class="required" name="data[Nombres]" required />
      </label>
      <label>
        Telefono *:
        <input type="tel" name="data[Telefono]" required />
      </label>
      <label>
        E-mail *:
        <input type="email" name="data[Email]" required />
      </label>
      <p style="text-align:center">
        <a class="btnNext" id="btn1" href="#">Adelante</a>
      </p>
    </div>
    <div id="step2" class="step">
      <h1>¡Bienvenido <span id="setName"></span>!</h1>
			<h4>Este es el inicio del sueño de <br>
			tu casa propia</h4>
			<h4>¿Estás listo?</h4>
			<p>Sólo responde Si o No a 4 preguntas para calificarte.</p>
			<a class="btnNext" id="btn2" href="#">¡Empecemos!</a>
    </div>
    <div id="step3" class="step question">
      <h3>1. ¿Conformas un grupo familiar?</h3>
      <p>
				Está conformado por un Jefe de Familia, que declarará a uno o más dependientes que pueden ser: su esposa, su conviviente, sus hijos, hermanos o nietos menores de 25 años o hijos mayores de 25 años con discapacidad, sus padres o abuelos.
			</p>
      <div class="cols-container">
        <div class="cols-6-md">
          <input type="radio" id="ques11" value="Si" name="data[ConformaGrupoFamiliar]" />
          <label for="ques11"><span>SI</span></label>
        </div>
        <div class="cols-6-md">
          <input type="radio" id="ques12" value="No" name="data[ConformaGrupoFamiliar]" />
          <label for="ques12"><span>NO</span></label>
        </div>
      </div>
      <a class="btnNext" id="btn3" href="#">Siguiente!</a>
    </div>
    <div id="step4" class="step question">
      <h3>2. ¿Tienes un ingreso menor a S/ 3600 soles?</h3>
      <p>
        El Ingreso Familiar Neto Mensual no debe exceder los S/ 3,626. En la pregunta 02 es ingreso neto familiar S/ 3,626.00 soles.
			</p>
      <div class="cols-container">
        <div class="cols-6-md">
          <input type="radio" id="ques21" value="Si" name="data[IngresoMenor3600]" />
          <label for="ques21"><span>SI</span></label>
        </div>
        <div class="cols-6-md">
          <label>
          <input type="radio" id="ques22" value="No" name="data[IngresoMenor3600]" />
          <label for="ques22"><span>NO</span></label>
        </div>
      </div>
      <a class="btnNext" id="btn4" href="#">Siguiente!</a>
    </div>
    <div id="step5" class="step question">
      <h3>3. ¿Tienes una propiedad?</h3>
      <p>
        Si quieren comprar una vivienda no podrán tener otra vivienda o terreno a nivel nacional.
			</p>
      <div class="cols-container">
        <div class="cols-6-md">
          <input type="radio" id="ques31" value="Si" name="data[TienePropiedad]" />
          <label for="ques31"><span>SI</span></label>
        </div>
        <div class="cols-6-md">
          <input type="radio" id="ques32" value="No" name="data[TienePropiedad]" />
          <label for="ques32"><span>NO</span></label>
        </div>
      </div>
      <a class="btnNext" id="btn5" href="#">Siguiente!</a>
    </div>
    <div id="step6" class="step question">
      <h3>4. ¿Has recibido ayuda del estado?</h3>
      <p>
        No haber recibido ayuda del estado
			</p>
      <div class="cols-container">
        <div class="cols-6-md">
          <input type="radio" id="ques41" value="Si" name="data[AyudaEstado]" />
          <label for="ques41"><span>SI</span></label>
        </div>
        <div class="cols-6-md">
          <input type="radio" id="ques42" value="No" name="data[AyudaEstado]" />
          <label for="ques42"><span>NO</span></label>
        </div>
      </div>
      <a class="btnNext" id="btn6" href="#">Siguiente!</a>
    </div>
    <div id="step7" class="step">
      <h1>Excelente</h1>
      <p>Gracias por completar el cuestionario</p>
      <p>Ahora pulsa el botón Enviar para finalizar el proceso</p>
      <p>Y estaremos comunicandonos pronto contigo.</p>
      <button class="btnFinish btnNext">¡Enviar mi informacion!</a>
    </div>
  </form>
  <div class="message_error"></div>
</div>
<div class="message_final">
</div>
<script>
  // Validaciones
  $(document).ready(function() {
    // Paso 1
    $('#btn1').click(function(event){
      event.preventDefault();
      if($('input[name="data[Nombres]"]').val()=="" || $('input[name="data[Telefono]"]').val()=="" || $('input[name="data[Email]"]').val()==""){
        $('.message_error').html("");
        $('.message_error').append("Los campos con * son obligatorios");
        return false;
      }
      $('.message_error').html("");
      $('#setName').append($('input[name="data[Nombres]"]').val());
      $('#step1').hide();
      $('#step2').show();
    });
    // Paso 2
    $('#btn2').click(function(event){
      event.preventDefault();
      $('#step2').hide();
      $('#step3').show();
    });
    // Paso 3
    $('#btn3').click(function(event){ // 1ra pregunta
      event.preventDefault();
      var radioValue = $("input[name='data[ConformaGrupoFamiliar]']:checked").val();
      console.log(radioValue);
      if(typeof radioValue==="undefined"){
        $('.message_error').html("Selecciona una opcion para continuar");
        return false;
      }
      $('.message_error').html("");
      $('#step3').hide();
      $('#step4').show();
    });
    // Paso 4
    $('#btn4').click(function(event){ // 2da pregunta
      event.preventDefault();
      var radioValue = $("input[name='data[IngresoMenor3600]']:checked").val();
      console.log(radioValue);
      if(typeof radioValue==="undefined"){
        $('.message_error').html("Selecciona una opcion para continuar");
        return false;
      }
      $('.message_error').html("");
      $('#step4').hide();
      $('#step5').show();
    });
    // Paso 5
    $('#btn5').click(function(event){ // 3ra pregunta
      event.preventDefault();
      var radioValue = $("input[name='data[TienePropiedad]']:checked").val();
      console.log(radioValue);
      if(typeof radioValue==="undefined"){
        $('.message_error').html("Selecciona una opcion para continuar");
        return false;
      }
      $('.message_error').html("");
      $('#step5').hide();
      $('#step6').show();
    });
    // Paso 6
    $('#btn6').click(function(event){ // 4ta pregunta
      event.preventDefault();
      var radioValue = $("input[name='data[AyudaEstado]']:checked").val();
      console.log(radioValue);
      if(typeof radioValue==="undefined"){
        $('.message_error').html("Selecciona una opcion para continuar");
        return false;
      }
      $('.message_error').html("");
      $('#step6').hide();
      $('#step7').show();
    });
    // Paso final
    $('#block_data').submit(function(event){
      event.preventDefault();
			$.ajax({
				method: 'post',
				url: '{servidor}rb-script/modules/blocknext/mailer.php',
				data: $( this ).serialize()
			})
			.done(function( data ) {
				if(data.result){
					console.log(data);
					$('.block_steps').slideUp();
					$('.message_final').html(data.msgHtml);
				}else{
					console.log(data);
					$('.message_final').html('<p style=\"color:red\">'+data.msg+'</p>');
				}
			});
    });
  });
</script>
