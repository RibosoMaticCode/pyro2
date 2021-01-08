<div class="frmSapiensOrdersFisico">
  <form id="frmData2" class="form">
  <div class="frmSapiensStep1">
    <div class="frmSapiensOrderHeader">
      <h2>Complete los datos para su pedido</h2>
    </div>
    <!--<h2 class="frmProductName"></h2>-->
    <p class="frmCoverPrice">Costo total: S/. <span class="frmProductPrice"></span> soles</p>
    <p class="frmCoverInfo">Completa el formulario para adquirir tus productos</p>
  	<input type="hidden" name="mode" value="new" required />
  	<input type="hidden" name="id" value="0" required />
    <input type="hidden" name="sendmail" value="1" required />
    <input type="hidden" name="total" value="" required />
    <label>
      <input type="text" name="names" value="" placeholder="Nombres *"  />
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
    <p style="text-align:center">
      <button type="submit" class="frmBtn">Enviar mi pedido</button>
    </p>
    <p style="text-align:right">
      <a class="frmSapiensClose" href="#"><i class="fas fa-times"></i></a>
    </p>
  </div>
  </form>
  <div class="frmSapiensStep3">
    <h2>Muchas gracias</h2>
    <p>Nos contactaremos contigo para procesar tu pedido.</p>
    <br />
    <br />
    <p>Serás redireccionado en breve, caso contrario pulsa el botón para seguir navegando en la web</p>
    <a href="<?= G_SERVER ?>" class="frmBtn">Seguir navegando</a>
  </div>
</div>