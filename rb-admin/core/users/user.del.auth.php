<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
if(isset($_GET['users'])){
	$user_array = json_decode($_GET['users'], true);
	echo "<pre>";
	print_r($user_array);
	echo "</pre>";
}
?>
<form id="del_user_auth" class="form">
	<?php
	if(isset($_GET['users'])){ // si hay lote de usuarios a eliminar
		?>
		<input type="text" value=<?= $_GET['users'] ?> name="users_array" required />
		<?php
	}else{
		?>
		<input type="hidden" value="<?= $_GET['user_id'] ?>" name="user_id" required />
  	<input type="hidden" value="<?= $_GET['user_key'] ?>" name="user_key" required />
		<?php
	}
	?>
  <p style="color:red">Esta acción es irreversible, no podra recuperar los datos de esta cuenta</p>
  <label>Escriba la contraseña del administrador, para confirmar:
    <input type="password" name="pwd_adm" id="pwd_adm" required autocomplete="disabled" />
  </label>
  <div class="cols-container">
    <div class="cols-6-md cols-content-left">
      <button type="submit" style="background-color:red">Eliminar</button>
    </div>
    <div class="cols-6-md cols-content-right">
      <button type="button" class="CancelFancyBox">Cancelar</button>
    </div>
  </div>
</form>
<script>
$(document).ready(function() {
  // Boton Cancelar
  $('.CancelFancyBox').on('click',function(event){
    $.fancybox.close();
  });

	<?php
	if(isset($_GET['users'])){ // si hay lote de usuarios a eliminar
		?>
	  // Send submit
	  $('#del_user_auth').submit(function( event ){
	    event.preventDefault();
	    /*$.ajax({
	      data: $( this ).serialize(),
	      url: '<?= G_SERVER ?>/rb-admin/core/users/user-del.php',
	      cache: false,
	      type: "POST",
	      success: function(data){
	        if(data.result == 1){
	          $.fancybox.close();
	          notify( data.message );
	          setTimeout(function(){
		          window.location.href = '<?= G_SERVER ?>/rb-admin/?pag=usu';
		        }, 1000);
	        }else{
	          notify(data.message);
	        }
	      }
	    });*/
			var users = $('input[name="users_array"]').val();
			var users_json = JSON.parse(users);// pasa json string to objects
			console.log(users_json);
			// Recorrer los objetos para ir eliminando uno a uno
			Object.keys(users_json).forEach(key => {
				console.log(key);
  			let value = users_json[key];
				console.log(value.userkey);
				console.log(value.userid);
				$.ajax({
		      data: $( this ).serialize(),
		      url: '<?= G_SERVER ?>/rb-admin/core/users/user-del.php',
		      cache: false,
		      type: "POST",
		      success: function(data){
		        if(data.result == 1){
		          $.fancybox.close();
		          notify( data.message );
		          setTimeout(function(){
			          window.location.href = '<?= G_SERVER ?>/rb-admin/?pag=usu';
			        }, 1000);
		        }else{
		          notify(data.message);
		        }
		      }
		    });
			});
	  });
		<?php
	}else{
		?>
	  // Send submit
	  $('#del_user_auth').submit(function( event ){
	    event.preventDefault();
	    $.ajax({
	      data: $( this ).serialize(),
	      url: '<?= G_SERVER ?>/rb-admin/core/users/user-del.php',
	      cache: false,
	      type: "POST",
	      success: function(data){
	        if(data.result == 1){
	          $.fancybox.close();
	          notify( data.message );
	          setTimeout(function(){
		          window.location.href = '<?= G_SERVER ?>/rb-admin/?pag=usu';
		        }, 1000);
	        }else{
	          notify(data.message);
	        }
	      }
	    });
	  });
		<?php
	}
	?>
});
</script>
