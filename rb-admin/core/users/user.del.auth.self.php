<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
?>
<form id="del_user_auth" class="form">
  <input type="hidden" value="<?= $_GET['user_id'] ?>" name="user_id" required />
  <input type="hidden" value="<?= $_GET['user_key'] ?>" name="user_key" required />
  <p style="color:red">Esta acción es irreversible, no podra recuperar los datos de esta cuenta</p>
  <label>Escriba su contraseña, para confirmar:
    <input type="password" name="pwd_user" id="pwd_user" required autocomplete="disabled" />
  </label>
  <div class="cols-container">
    <div class="cols-6-md cols-content-left">
      <button type="submit" class="button btn-delete">Eliminar</button>
    </div>
    <div class="cols-6-md cols-content-right">
      <button type="button" class="button CancelFancyBox">Cancelar</button>
    </div>
  </div>
</form>
<script>
$(document).ready(function() {
  // Boton Cancelar
  $('.CancelFancyBox').on('click',function(event){
    $.fancybox.close();
  });

  // Send submit
  $('#del_user_auth').submit(function( event ){
    event.preventDefault();
    $.ajax({
      data: $( this ).serialize(),
      url: '<?= G_SERVER ?>rb-admin/core/users/user.del.self.php',
      cache: false,
      type: "POST",
      success: function(data){
        if(data.result == 1){
          $.fancybox.close();
          notify( data.message );
          setTimeout(function(){
	          window.location.href = '<?= G_SERVER ?>login.php?out';
	        }, 1000);
        }else{
          notify(data.message);
        }
      }
    });
  });
});
</script>
