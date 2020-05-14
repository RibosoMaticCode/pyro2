<script src="{ruta_modulo}sapiens.orders.formfrontend/form.js"></script>
<div class="frmSapiensOrders">
  <div class="frmSapiensOrderHeader">
  <img src="{ruta_modulo}sapiens.orders.formfrontend/orderheader.jpg" alt="img" />
  </div>
  <div class="frmSapiensStep1">
  <form id="frmData" class="form">
    <p>Completa el formulario para adquirir tu producto</p>
  	<input type="hidden" name="mode" value="new" required />
  	<input type="hidden" name="id" value="0" required />
    <input type="hidden" name="sendmail" value="1" required />
    <label>
      <input type="text" name="names" required value="" placeholder="Nombres *"  />
    </label>
    <label>
      <input type="text" name="lastnames" required value="" placeholder="Apellidos"  />
    </label>
    <label>
      <input type="tel" name="phone" value="" placeholder="Celular"  />
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
    <p><strong>Entrega:</strong></p>
    <label>
      <input type="radio" name="delivery" value="0" checked /> Enviar a mi dirección
      <input type="text" name="address" placeholder="Escribe tu direccion" />
    </label>
    <label>
      <input type="radio" name="delivery" value="1" /> Recojo en tienda
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
    <p>BCP 850 91828102 020</p>
    <p>BBVA 127 12121 10910 00</p>
    <p><strong>Coordinar pago por Whatsapp</strong></p>
    <p><a href="https://api.whatsapp.com/send?phone=51920810299">+51 920 810 299</a></p>
  </div>
  <p style="text-align:right">
    <a class="frmSapiensClose" href="#">Cerrar</a>
  </p>
</div>