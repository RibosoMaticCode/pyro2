/*
btnSend: Nombre del boton que enviara el formulario

adicionar: data-callback="enableBtn", a la configuracion que proporciona Google Captcha
*/

window.onload = function() {
  if( document.getElementById("btnSend") !== null ){
    document.getElementById("btnSend").disabled = true;
  }
}

function enableBtn(){
  document.getElementById("btnSend").disabled = false;
}
