<?php
// Variables necesarias: $operation_id, $total, $email
?>
<style>
#paymentModal { z-index: 1000; }
#stripeModal { z-index: 1100; }
.btn-Checkout {
    background:orangered; color:white; border:none; padding:10px 20px; border-radius:5px;text-decoration:none;
}
</style>

<!-- Payment Modal -->
<section id="paymentModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000;">
  <div style="position:relative; margin:5% auto; width:90%; max-width:500px; background:white; padding:20px; border-radius:8px;">
    <button id="closePaymentModal" style="position:absolute; top:10px; right:10px;">&times;</button>
    <h2 style="color:orangered;">Seleccione método de pago</h2>
  
    <form id="paymentForm" method="POST" action="index.php?page=collection&action=process">
      <input type="hidden" name="quote_id" value="<?= $operation_id ?>">
      <input type="hidden" name="email" value="<?= $email ?>">

      <label><input type="radio" name="payment_method" value="stripe" checked> Tarjeta de Débito/Crédito</label><br>
      <label><input type="radio" name="payment_method" value="cash"> Efectivo</label><br>
      <label><input type="radio" name="payment_method" value="bank"> Transferencia Bancaria</label>

      <div id="offlinePaymentFields" style="display:none; margin-top:10px;">
        <label>Monto a abonar (€):
          <input type="number" step="0.01" name="amount" placeholder="<?= number_format($total,2,'.',''); ?>">
        </label>
        <div id="bankFields" style="display:none; margin-top:10px;">
          <label>Nombre Banco:<input type="text" name="bank_name"></label><br>
          <label>Número de Transacción:<input type="text" name="transaction_number"></label><br>
          <label>Fecha:<input type="date" name="payment_date" value="<?= date('Y-m-d'); ?>"></label>
        </div>
      </div>

      <div style="margin-top:15px; text-align:right;">
        <button type="button" id="checkoutBtn" class="btn-Checkout">Checkout</button>
      </div>
    </form>
  </div>
</section>

<!-- Stripe Modal -->
<section id="stripeModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1100;">
  <div style="position:relative; margin:5% auto; width:90%; max-width:600px; background:white; padding:20px; border-radius:8px;">
    <button id="closeModal">&times;</button>
    <iframe id="stripeIframe" src="" style="width:100%; height:400px; border:none;"></iframe>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {

  const paymentModal = document.getElementById('paymentModal');
  const stripeModal = document.getElementById('stripeModal');
  const radios = document.querySelectorAll('input[name="payment_method"]');
  const offlineFields = document.getElementById('offlinePaymentFields');
  const bankFields = document.getElementById('bankFields');

  // Abrir modal
  document.getElementById('payButton').addEventListener('click', e => {
    e.preventDefault();
    paymentModal.style.display = 'block';
  });

  // Cerrar modal
  document.getElementById('closePaymentModal').addEventListener('click', () => {
    paymentModal.style.display = 'none';
  });

  document.getElementById("closeModal").addEventListener("click", () => {
    stripeModal.style.display = "none";
    document.getElementById("stripeIframe").src = '';
    paymentModal.style.display = "block";
  });

  // Mostrar campos offline
  radios.forEach(radio => {
    radio.addEventListener('change', function() {
      offlineFields.style.display = this.value === 'stripe' ? 'none' : 'block';
      bankFields.style.display = this.value === 'bank' ? 'block' : 'none';
    });
  });

  // Checkout
  document.getElementById('checkoutBtn').addEventListener('click', async function(){

    const method = document.querySelector('input[name="payment_method"]:checked').value;
    const quote_id = document.querySelector('[name="quote_id"]').value;
    const email = document.querySelector('[name="email"]').value;

    const amount = document.querySelector('[name="amount"]')?.value || '';
    const bank_name = document.querySelector('[name="bank_name"]')?.value || '';
    const transaction_number = document.querySelector('[name="transaction_number"]')?.value || '';
    const payment_date = document.querySelector('[name="payment_date"]')?.value || '';

    // Pago Stripe
    if(method === 'stripe'){
        const total = <?= $total ?>;
        document.getElementById("stripeIframe").src = 
            `https://ikusa.net/stripe/index.php?amount=${total}&operation=${quote_id}&email=${email}`;
        stripeModal.style.display = "block";
        paymentModal.style.display = "none";
        return;
    }

    // Pago offline
    const data = new FormData();
    // data.append('quote_id', quote_id);
    data.append('email', email);
    data.append('payment_method', method);
    // data.append('amount', amount);
    data.append('bank_name', bank_name);
    data.append('transaction_number', transaction_number);
    data.append('payment_date', payment_date);
    data.append('operation_id', quote_id);   // antes 'quote_id'
    data.append('amount_partial', amount);   // antes 'amount'


    try {

        const response = await fetch('index.php?page=collection&action=process', {
            method: 'POST',
            body: data,
            headers: { "X-Requested-With": "XMLHttpRequest" }
        });


        const result = await response.text();
        console.log('Respuesta del servidor:', result);

        alert('Payment recorded successfully');
        paymentModal.style.display = 'none';

    } catch (error) {
        console.error('Error enviando el pago:', error);
        alert('Error al registrar el pago');
    }

  });

});
</script>
