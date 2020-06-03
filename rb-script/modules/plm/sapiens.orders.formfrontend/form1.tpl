<div class="frmSapiensOrdersFisico">
  <div class="frmSapiensOrderHeader">
  <img src="{ruta_modulo}sapiens.orders.formfrontend/orderheader.jpg" alt="img" />
  </div>
  <form id="frmData2" class="form">
  <div class="frmSapiensStep1">
  
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
    <label>
      <input type="text" name="career" value="" placeholder="Carrera que postula"  />
    </label>
    <label>
      <input type="text" name="school" value="" placeholder="Colegio de procedencia" />
    </label>
    <p><strong>Entrega:</strong></p>
    <label>
      <input type="radio" name="delivery" value="0" checked /> Enviar a esta dirección
    </label>
    <label>
      <input style="margin-left:20px;"type="text" name="address" placeholder="Escribe tu direccion" />
    </label>
    <div class="cols-container" style="margin-left:20px;margin-bottom:10px">
      <div class="cols-4-md">
        <input type="radio" name="costo_delivery" value="5.00" checked /> Trujillo Centro <br />S/. 5.00
      </div>
      <div class="cols-4-md">
        <input type="radio" name="costo_delivery" value="7.00" /> Distritos <br />S/. 7.00
      </div>
      <div class="cols-4-md">
        <input type="radio" name="costo_delivery" value="0.00" /> Fuera de Trujillo
      </div>
    </div>
    <label>
      <input type="radio" name="delivery" value="1" /> Recojo en tienda
    </label>
    <p style="text-align:center">
      <a class="frmNextTo2 frmBtn" href="#">Siguiente</a>
    </p>
    <p style="text-align:right">
      <a class="frmSapiensClose" href="#"><i class="fas fa-times"></i></a>
    </p>
  </div>
  <div class="frmSapiensStep2">
    <h2>Hola <span class="frmUserName"></span></h2>
    <p>¡Felicidades! Estás a un paso de adquirir tus productos</p>
    <!--<h3 class="frmProductName"></h3>-->
    <p>El monto a depositar es:</p>
    <p style="font-weight:bold">S/. <span class="frmTotal"></span> soles</p>
    <p>Puedes hacerlo depositando el monto a la siguiente cuenta:</p>
    <p class="frmCuenta">Banco de Crédito del Perú - BCP <br />
      570 - 7150004-0-36</p>
    <p>Ingresa aquí tu número de operación:</p>
    <p>
      <input type="text" style="width:70%;min-width:auto!important" name="num_operacion" />
    </p>
    <p>O también puedes enviar a nuestro Whatsapp, luego</p>
    <p><a class="frmBtnWhatsapp" href="https://api.whatsapp.com/send?phone=51924986883"><img src="{ruta_modulo}sapiens.orders.formfrontend/whatsapp.png" alt="img" /> 924 986 883</a></p>
    <p style="text-align:center">
      <button type="submit" class="frmBtn">Finalizar</button>
    </p>
    <p style="text-align:right">
      <a class="frmSapiensClose" href="#"><i class="fas fa-times"></i></a>
    </p>
  </div>
  </form>
  <div class="frmSapiensStep3">
    <h2>Muchas gracias <span class="frmUserName"></span></h2>
    <p>Luego de validar tus datos y el deposito estaremos comunicandonos inmediatamente y enviando tu libro.</p>
    <br />
    <h3>¡Muchos éxitos!</h3>
    <br />
    <a href="#" class="frmBtn frmSapiensClose">Seguir navegando en Sapiens</a>
  </div>
</div>