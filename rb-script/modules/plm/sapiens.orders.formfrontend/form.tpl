<div class="frmSapiensOrdersDigital">
  <div class="frmSapiensOrderHeader">
    <img src="{ruta_modulo}sapiens.orders.formfrontend/orderheader.jpg" alt="img" />
  </div>
  <div class="frmSapiensStep1">
  <form id="frmData1" class="form">
  	<input type="hidden" name="mode" value="new" required />
  	<input type="hidden" name="id" value="0" required />
    <input type="hidden" name="sendmail" value="1" required />
    <label>
      <input type="text" name="names" required value="" placeholder="Nombres *"  />
    </label>
    <label>
      <input type="text" name="lastnames" value="" placeholder="Apellidos"  />
    </label>
    <label>
      <input type="tel" name="phone" value="" placeholder="Celular *"  />
    </label>
  	<label>
      <input type="email" name="email" value="" placeholder="E-mail *"  />
    </label>
  	<label>
      <input type="text" name="career" value="" placeholder="Carrera que postula"  />
    </label>
    <label>
      <input type="text" name="school" value="" placeholder="Colegio de procedencia" />
    </label>
    <p style="text-align:center">
      <button type="submit" class="button btn-primary">Enviar</button>
    </p>
  </form>
  </div>
  <div class="frmSapiensStep2">
    <h2>Datos registrados</h2>
    <p>Para finalizar el proceso, realizar tu pago de esta forma:</p>
    <p><strong>Deposito a cuenta corriente</strong></p>
    <p>BCP 570-7150004-0-36</p>
    <p><strong>Coordinar pago por Whatsapp</strong></p>
    <p><a href="https://api.whatsapp.com/send?phone=51924986883">+51 924 986 883</a></p>
  </div>
  <p style="text-align:right">
    <a class="frmSapiensClose" href="#">Cerrar</a>
  </p>
</div>