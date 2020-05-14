<script src="{ruta_modulo}sapiens.orders.formfrontend/form.js"></script>
<div class="frmSapiensOrders">
  <div class="frmSapiensStep1">
  <form id="frmData" class="form">
  	<input type="hidden" name="mode" value="new" required />
  	<input type="hidden" name="id" value="0" required />
    <input type="hidden" name="sendmail" value="1" required />
    <label>
  		Nombres:
      <input type="text" name="names" required value="" />
    </label>
    <label>
      Apellidos:
      <input type="text" name="lastnames" required value="" />
    </label>
    <label>
      Telefono celular:
      <input type="tel" name="phone" value="" />
    </label>
  	<label>
  		Correo:
      <input type="email" name="email" value="" />
    </label>
  	<label>
      Carrera postula:
      <input type="text" name="career" value="" />
    </label>
    <label>
      Colegio de procedencia:
      <input type="text" name="school" value="" />
    </label>
    <button type="submit" class="button btn-primary">Registrar mi pedido</button>
  </form>
  </div>
  <div class="frmSapiensStep2">
    <h2>Datos registrados</h2>
    <p>Para finalizar el proceso, realizar tu pago de esta forma:</p>
    <p><strong>Deposito a cuenta corriente</strong></p>
    <p>BCP 850 91828102 020</p>
    <p>BBVA 127 12121 10910 00</p>
    <p><strong>Coordinar pago por Whatsapp</strong></p>
    <p><a href="https://api.whatsapp.com/send?phone=51920810299">+51 920 810 299</a></p>
  </div>
  <p style="text-align:right">
    <a class="frmSapiensClose" href="#">Cerrar</a>
  </p>
</div>