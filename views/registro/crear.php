<main class="registro">
  <h2 class="registro__heading"><?php echo $titulo; ?></h2>
  <p class="registro__descripcion">Elige tu plan</p>

  <div class="paquetes__grid">
    <div class="paquete">
      <h3 class="paquete__nombre">Pase Gratis</h3>
      <ul class="paquete__lista">
        <li class="paquete__elemento">Acceso Virtual a Power Platform Camp</li>
      </ul>

      <p class="paquete__precio">$0</p>

      <form method="POST" action="/finalizar-registro/gratis">
        <input class="paquetes__submit" type="submit" value="Inscripción Gratis">
      </form>
    </div>

    <div class="paquete">
      <h3 class="paquete__nombre">Asistencia Presencial</h3>
      <ul class="paquete__lista">
        <li class="paquete__elemento">Asistencia Presencial sólo en Costa Rica</li>
        <!--  <li class="paquete__elemento">Pase por 2 días</li> 
       <li class="paquete__elemento">Acceso a talleres y conferencias</li>
        <li class="paquete__elemento">Acceso a las grabaciones</li>
        <li class="paquete__elemento">Camisa del Evento</li>
        <li class="paquete__elemento">Comida y Bebida</li> -->
      </ul>

      <p class="paquete__precio">$100</p>

      <div id="smart-button-container">
        <div style="text-align: center;">
          <div id="paypal-button-container"></div>
        </div>
      </div>


    </div>

    <div class="paquete">
      <h3 class="paquete__nombre">Pase Virtual</h3>
      <ul class="paquete__lista">
        <li class="paquete__elemento">Acceso Virtual a Power Platform Camp</li>
        <li class="paquete__elemento">Pase por 2 días</li>
        <li class="paquete__elemento">Acceso a talleres y conferencias</li>
        <li class="paquete__elemento">Acceso a las grabaciones</li>
      </ul>

      <p class="paquete__precio">$49</p>

      <div id="smart-button-container">
        <div style="text-align: center;">
          <div id="paypal-button-container-virtual"></div>
        </div>
      </div>
    </div>
  </div>
</main>

<script src="https://www.paypal.com/sdk/js?client-id=AYE1Re-2a1SGJukhREFZbOy0i8nlIOi66aao9HE7NOpTUhEN70cQ1SfxK6SY8H-47xCaLEMcM1BuD9Dq" data-sdk-integration-source="button-factory"></script>

<script>
  function initPayPalButton() {
    paypal.Buttons({
      style: {
        shape: 'rect',
        color: 'blue',
        layout: 'vertical',
        label: 'pay',
      },

      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            "description": "1",
            "amount": {
              "currency_code": "USD",
              "value": 100
            }
          }]
        });
      },

      onApprove: function(data, actions) {
        return actions.order.capture().then(function(orderData) {

          const datos = new FormData();
          datos.append('paquete_id', orderData.purchase_units[0].description);
          datos.append('pago_id', orderData.purchase_units[0].payments.captures[0].id);

          fetch('/finalizar-registro/pagar', {
              method: 'POST',
              body: datos
            })
            .then(respuesta => respuesta.json())
            .then(resultado => {
              if (resultado.resultado) {
                actions.redirect('http://localhost:3000/finalizar-registro/conferencias');
              }
            })

        });
      },

      onError: function(err) {
        console.log(err);
      }
    }).render('#paypal-button-container');


    // Pase virtual
    paypal.Buttons({
      style: {
        shape: 'rect',
        color: 'blue',
        layout: 'vertical',
        label: 'pay',
      },

      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            "description": "2",
            "amount": {
              "currency_code": "USD",
              "value": 49
            }
          }]
        });
      },

      onApprove: function(data, actions) {
        return actions.order.capture().then(function(orderData) {

          const datos = new FormData();
          datos.append('paquete_id', orderData.purchase_units[0].description);
          datos.append('pago_id', orderData.purchase_units[0].payments.captures[0].id);

          fetch('/finalizar-registro/pagar', {
              method: 'POST',
              body: datos
            })
            .then(respuesta => respuesta.json())
            .then(resultado => {
              if (resultado.resultado) {
                actions.redirect('http://localhost:3000/finalizar-registro/conferencias');
              }
            })

        });
      },

      onError: function(err) {
        console.log(err);
      }
    }).render('#paypal-button-container-virtual');

  }
  initPayPalButton();
</script>