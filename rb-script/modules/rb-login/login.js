$(document).ready(function() {
  /*
  // Disable keys
  function disabled_key(e){
    if(e.keyCode == 37 || e.keyCode == 38 || e.keyCode == 39 || e.keyCode == 40 || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 16 || e.keyCode == 17 || e.keyCode == 20){
      //console.log("disabled");
      return false;
    }
  }

  // Password validado
  function pass_valid(pass, pass_id){
    var response = false;
    var url = "<?= $rm_url ?>rb-script/modules/rb-login/validate.pass.php";
    if(pass.length>1){
      $.ajax({
        async: false, // respeta variable response como retorno, sino no lo toma en cuenta
        type: "GET",
        url: url,
        data: "pass="+pass.trim(),
        success: function(data){
          //console.log(data);
          if(data=="1"){
            $("#"+pass_id).removeClass('pass_invalid').addClass('pass_valid');
            $("#"+pass_id+"_notify").text("");
            response = true;
          }else{
            $("#"+pass_id).removeClass('pass_valid').addClass('pass_invalid');
            $("#"+pass_id+"_notify").text("Contraseña no es segura");
            response = false;
          }
        }
      });
    }
    return response;
    console.log("rpsta:"+response);
  }

  // mail
  $("#nickname").blur(function() {
    var text = $(this).val();
    if(text.length==0){
      $("#nickname_notify").text("Campo no debe quedar vacio");
      $("#nickname").removeClass('pass_valid').addClass('pass_invalid');
    }
  });
  $("#nickname").keyup(function(e) {
    if(disabled_key(e)==false) return;
    var url = "<?= $rm_url ?>rb-script/modules/rb-login/validate.mail.php";
    var text = $(this).val();
    if(text.length>1){
      $.ajax({
        type: "GET",
        url: url,
        data: "mail="+text,
        success: function(data){
          console.log(data);
          if(data=="0"){
            $("#nickname").removeClass('pass_invalid').addClass('pass_valid');
            $("#nickname_notify").text("");
          }
          if(data=="1"){
            $("#nickname").removeClass('pass_valid').addClass('pass_invalid');
            $("#nickname_notify").text("Correo eléctronico registrado, intente otro.");
          }
          if(data=="2"){
            $("#nickname").removeClass('pass_valid').addClass('pass_invalid');
            $("#nickname_notify").text("Correo eléctronico inválido.")
          }
        }
      });
    }
  });

  // pass 1
  $("#pass1").blur(function() {
    var text = $(this).val();
    if(text.length==0){
      $("#pass1_notify").text("Campo no debe quedar vacio");
      $("#pass1").removeClass('pass_valid').addClass('pass_invalid');
    }
  });
  $("#pass1").keyup(function(e) {
    e.preventDefault();
    if(disabled_key(e)==false) return;
    var text = $(this).val();
    if(pass_valid(text, "pass1")===true){
      coinciden("pass1", "pass2");
    }
  });
  // pass 2
  $("#pass2").blur(function() {
    var text = $(this).val();
    if(text.length==0){
      $("#pass2_notify").text("Campo no debe quedar vacio");
      $("#pass2").removeClass('pass_valid').addClass('pass_invalid');
      return false;
    }
  });
  $("#pass2").keyup(function(e) {
    e.preventDefault();
    if(disabled_key(e)==false) return;
    var text = $(this).val();
    if(pass_valid(text, "pass2")===true){
      coinciden("pass1", "pass2");
    }
  });

  // Coincidencia de passwords
  $("#pass1, #pass2").blur(function() {
    //if(pass_valid(pass1,"pass1")==true && pass_valid(pass2,"pass2")==true){
      coinciden("pass1", "pass2");
    //}
  });

  function coinciden(pass1, pass2){
    pass1 = $("#"+pass1).val();
    pass2 = $("#"+pass2).val();
    if(pass1.length > 0 && pass2.length > 0){
      // Primero verificamos que sean validaas
      console.log(pass1);
      console.log(pass2);
      if(pass_valid(pass1,"pass1")===true && pass_valid(pass2,"pass2")===true){
        console.log("Ambas validas");
        if(pass1 != pass2){
          console.log("No coinciden");
          $("#pass1, #pass2").removeClass('pass_valid').addClass('pass_invalid');
          $("#pass2_notify").text("Las contraseñas no coinciden");
        }else{
          console.log("Coinciden");
          $("#pass1, #pass2").removeClass('pass_invalid').addClass('pass_valid');
          //$("#pass2_notify").text("Las contraseñas no coinciden");
        }
      }else{
        console.log("Invalidas");
      }
    }
  }
  */
  $("#frmRegister").submit(function(e) {
    e.preventDefault();
    var url = "../rb-script/modules/rb-login/user.register.php";
      $.ajax({
        type: "POST",
        url: url,
        data: $("#frmRegister").serialize(),
        dataType: 'json',
        success: function(data){
          if(data['codigo']==0){ // Codigo correcto!
            $('#frmRegister').slideUp();
            $(".bg, #msj-final").show();
            $("#msj-final").html(data['mensaje']);
          }else{
            $(".bg, #msj-frm").show().delay(4000).fadeOut();
            $("#msj-frm").html(data['mensaje']);
          }
        }
      });
  });

  $('#terms_check').click(function(e){
    if ($('#terms_check').is(':checked')) {
      $('.bg').show();
      $('.terms').show();
    }else{
      $('.btnRegister').prop('disabled', true);
    }
  });
  $('.btnCancel').click(function(e){
    $('.bg').hide();
    $('.terms').hide();
    $('#terms_check').prop('checked', false);
  });
  $('#terms_confirm').click(function(e){
    $('.bg').hide();
    $('.terms').hide();
    $('.btnRegister').prop('disabled', false);
  });
});
