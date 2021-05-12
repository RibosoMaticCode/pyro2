<div class="frmOrder">
    <form id="orderFormClient" class="form">
        <h2>Complete los datos para registrar su pedido</h2>
        <label>
            <input type="text" name="nombres" placeholder="Nombres *" required />
        </label>
        <label>
            <input type="text" name="apellidos" placeholder="Apellidos" required />
        </label>
        <label>
            <input type="text" name="direccion" value="" placeholder="Direccion" />
        </label>
        <label>
            <input type="email" name="correo" value="" placeholder="E-mail *" required />
        </label>
        <label>
            <input type="tel" name="telefono_movil" value="" placeholder="Celular *" required  />
        </label>
        <p style="text-align:center">
            <button type="submit" class="btn">Realizar mi pedido</button>
        </p>
    </form>
    <div id="orderResultMessage"></div>
    <a href="#" id="btnCloseClientForm">Cerrar</a>
</div>