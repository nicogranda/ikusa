<section id="stripeModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000;">
    <div style="position:relative; margin:5% auto; width:90%; max-width:600px; background:white; padding:20px; border-radius:8px;">
        <button id="closeModal" style="position:absolute; top:10px; right:10px; background:orangered; color:white; border:none; border-radius:50%; width:30px; height:30px; cursor:pointer;">&times;</button>
        <iframe id="stripeIframe" src="" style="width:100%; height:400px; border:none;"></iframe>
    </div>
</section>

<section id="rfqModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,.5); z-index:2000;">
    <div style="position:relative; margin:5% auto; width:90%; max-width:700px; background:#fff; padding:20px; border-radius:8px;">

        <button type="button" id="closeRfqModal"
            style="position:absolute; top:10px; right:10px;">×</button>

        <h3>Suppliers for RFQ</h3>

        <label>
            <input type="checkbox" id="selectAllSuppliers">
            Select All
        </label>

        <div id="rfqSuppliersList" style="margin-top:15px;"></div>

        <hr>

        <button type="button" onclick="sendRFQ()">Generate RFQ</button>

    </div>
</section>

<main class='container-form'>
<form name="form1" action="index.php?page=quotes&action=update&id=<?php echo $operation['id']; ?>" method="POST">
    
<section class="table-container" style="">
     <table class="customer-table">
        <tr>
            <th colspan="8" style="background-color:white; color:orangered; text-align:right; border: none;">
                <span style="color:gray; text-align:right;">Quote:</span>
                <span style="color:orangered; text-align:right;"><?php echo $operation['id']; ?></span><br>
                <span style="color:gray; text-align:right;font-size:10px;"><?php echo $operation['created_at']; ?></span>
            </th>
        </tr>
        <tr>
            <th colspan='8' style="text-align:left; border: none; font-weight:400;">
                <p class="customer-data"><input type="text" name="operation['alias']" value="<?php echo $operation['business_alias'];?>" style='text-align:left;'></p>
                <p class="customer-data" style='font-weight:800;'><?php echo $operation['business_name'];?></p>
                <p class="customer-data" style='color:gray;'><?php echo $operation['business_email'];?></p>
                <p class="customer-data" style='color:gray;'><?php echo $operation['business_address'];?></p>
            </th>
        </tr>
    </table>

 <table class="quote-table">
    <thead>
        <tr>
            <th class="col-concept">Goods/Service</th>
            <th class="col-number">Qty</th>
            <th class="col-number">Unit Value (€)</th>
            <th class="col-number">Unit</th>
            <th class="col-number">Discount</th>
            <th class="col-number">VAT Rate</th>
            <th class="col-number">Total (€)</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($operation['details'] as $detail): ?>
        <tr>
            <td class="col-concept"><?= htmlspecialchars($detail['product_name']) ?></td>
            <td class="col-number">
                <input type="text" class="quote-input" 
                       name="operation_detail[<?= $detail['id'] ?>][quantity]" 
                       value="<?= $detail['quantity'] ?>">
            </td>
            <td class="col-number">
                <input type="text" class="quote-input" 
                       name="operation_detail[<?= $detail['id'] ?>][unit_value]" 
                       value="<?= number_format($detail['unit_value'], 2, '.', '') ?>">
            </td>
            <td class="col-number"><?= htmlspecialchars($detail['unit']) ?></td>
            <td class="col-number">
                <input type="text" class="quote-input" 
                       name="operation_detail[<?= $detail['id'] ?>][discount]" 
                       value="<?= number_format($detail['discount'], 2) ?>">
            </td>
            <td class="col-number">
                <input type="text" class="quote-input" 
                       name="operation_detail[<?= $detail['id'] ?>][vat_rate]" 
                       value="<?= number_format($detail['vat_rate'], 2) ?>">
            </td>
            <td class="col-number"><?= number_format($detail['balance'], 2) ?></td>
            <td>
                <input type="checkbox" name="del[]" value="<?= $detail['id'] ?>">
                <input type="hidden" name="item[]" value="<?= $detail['id'] ?>">
            </td>
        </tr>
        <tr>
           <td colspan="8">
                <textarea class="note-input" 
                          name="operation_detail[<?= $detail['id'] ?>][note]"><?= htmlspecialchars($detail['note']) ?>
                </textarea>
            </td>

        </tr>
        <?php endforeach; ?>

        <tr>
            <td colspan="6" class="col-concept">VAT Rate</td>
            <td class="col-number"><?= number_format($operation['vat'], 2) ?></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6" class="col-concept">Total</td>
            <td class="col-number"><?= number_format($operation['total'], 2) ?></td>
            <td></td>
        </tr>
    </tbody>
</table>
  <div style='color:red;'><?= $_SESSION['message'] ?? '' ?></div>
</section>

    <input type="hidden" name="email"  value="<?php echo  $operation['business_email'];?>" id="operation_email" >    
    <input type="hidden" name="operation_id"  value="<?php echo  $operation['id'];?>" id="operation_id" >

    <section class="events table-container">   
        <input type="submit" name="update" value="Update">
        <a href="index.php?page=quote_details&action=create&id=<?php echo $operation['id']; ?>">+</a>
        
        <button type="button" onclick="deleteSelected()">Delete</button>
        
        <!--<button type="button" id="rfqButton">RFQ</button>-->
        <!-- BOTÓN DESDE TU VIEW ACTUAL -->

        <a href="/admin/index.php?page=rfq&action=create&quote=<?php echo $operation['id']; ?>">
            RFQ
        </a>

        <input type="button" name="print" value="Print" onclick="downloadPDF()">
        <a href="fpdf/agreement.php" target="_blank">Agreement</a>
        <a href="index.php?page=quotes&action=mail&id=<?php echo $operation['id']; ?>">Mail</a>

        <a href="#" id="payButton">Pay</a>
        <?php 
        $operation_id = $operation['id'];
        $total = $operation['total'];
        $email = $operation['business_email'];
        include '../../app/views/components/collection.php'; 
        ?>

        <?php 
            if($operation['required']){
                echo $operation['required'];
            } else {
        ?>
            <a href="index.php?page=invoices&action=create&operation=<?php echo $operation['id'];?>">Invoice<?php echo $operation['required'];?></a>        
        <?php 
            }
        ?>       

        
        <a href="index.php?page=quotes&action=index"> Otro</a>
        
      

    </section>   
    
</form>

<?php include "../../app/views/admin/sales/collections/index.php";?>
<input type="button" name="collection_pdf" value="Collection" onclick="collection_PDF()">


</main>

<script>
    function deleteSelected() {
        const checked = document.querySelectorAll('input[name="del[]"]:checked');
    
        if (checked.length === 0) {
            alert('Selecciona al menos un ítem');
            return;
        }
    
        if (!confirm('¿Eliminar los ítems seleccionados?')) return;
    
        const formData = new FormData();
        const operationId = document.getElementById('operation_id').value;
        formData.append('operation_id', operationId);
    
        const delItems = [];
        checked.forEach(cb => {
            formData.append('del[]', cb.value);
            delItems.push(cb.value);
        });
    
        console.log("Enviando delete request:");
        console.log("operation_id:", operationId);
        console.log("items a eliminar:", delItems);
    
        fetch('index.php?page=quote_details&action=delete', {
            method: 'POST',
            body: formData
        })
        .then(res => {
            console.log("Respuesta recibida:", res);
            if (!res.ok) throw new Error('HTTP error');
            // El backend hace redirect, así que recargamos
            window.location.reload();
        })
        .catch(err => {
            console.error("❌ Error de conexión:", err);
            alert('Error de conexión');
        });
    }

    function collection_PDF() {
        var operationId = document.getElementById('operation_id').value;
        var url = 'https://ikusa.net/admin/index.php?page=collection&action=print&id=' + operationId;
        window.open(url, '_blank');
    }

    function downloadPDF() {
      
        // Capturamos el valor de budget_id y redirigimos al enlace con ese parámetro
        var operationId = document.getElementById('operation_id').value;
        //var url = 'https://ikusa.net/admin/fpdf/quote.php?id=' + operationId;
         
        var url = 'https://ikusa.net/admin/index.php?page=quotes&action=print&id=' + operationId;
        // var url = 'https://ikusa.net/admin/fpdf/quote.php?id=' + quoteId;
        // Abre la URL en una nueva pestaña
        window.open(url, '_blank');
        // Redirige a la URL que genera el PDF
        //window.location.href = url;
    }
    
    function openStripeWindow() {
        window.open('https://ikusa.net/stripe/index.php', '_blank', 'width=600,height=700');
    }
    
    function openStripeModal(total) {
        var email = document.getElementById("operation_email").value;
        var operation = document.getElementById("operation_id").value;
        var modal = document.getElementById("stripeModal");
        var iframe = document.getElementById("stripeIframe");
        iframe.src = `https://ikusa.net/stripe/index.php?amount=${total}&operation=${operation}&email=${email}`; // Pasa el monto a Stripe
        // Asegura que 'total' esté en el formato correcto
        if (!total || isNaN(parseFloat(total))) {
            alert("El monto no es válido");
            return;
        }

        // Muestra el modal
        modal.style.display = "block";
    }

    // Cerrar modal al hacer clic en el botón de cerrar
    document.getElementById("closeModal").addEventListener("click", function () {
        document.getElementById("stripeModal").style.display = "none";
        document.getElementById("stripeIframe").src = ''; // Limpia el iframe
    });

    // Cerrar el modal al hacer clic fuera de él
    window.onclick = function (event) {
        const modal = document.getElementById('stripeModal');
        if (event.target === modal) {
            const iframe = document.getElementById('stripeIframe');
            iframe.src = ''; 
            modal.style.display = 'none';
        }
    };

    window.onclick = function (event) {
        const modal = document.getElementById('stripeModal');
        if (event.target === modal) {
            const iframe = document.getElementById('stripeIframe');
            iframe.src = ''; 
            modal.style.display = 'none';
        }
    };

    document.getElementById('rfqButton')?.addEventListener('click', RFQ);

    // Guarda los ítems al abrir el modal
    let selectedItems = [];

function RFQ() {
    const checked = document.querySelectorAll('input[name="del[]"]:checked');
    if (checked.length === 0) { alert('Selecciona items'); return; }

    selectedItems = []; // ← resetea
    const formData = new FormData();
    checked.forEach(cb => {
        formData.append('items[]', cb.value);
        selectedItems.push(cb.value); // ← guarda para sendRFQ
    });
    formData.append('quote_id', document.getElementById('operation_id').value);

    fetch('index.php?page=rfq&action=suppliers', { method: 'POST', body: formData })
    .then(r => r.text())
    .then(raw => {
        try {
            const data = JSON.parse(raw);
            let html = '';
            data.forEach(row => {
                html += `<label style="display:block; margin-bottom:8px;">
                    <input type="checkbox" name="supplier[]" value="${row.id}"> ${row.name}
                </label>`;
            });
            document.getElementById('rfqSuppliersList').innerHTML = html;
            
            document.getElementById('rfqModal').style.display = 'block';
        } catch(e) {
            console.error('Respuesta no es JSON:', raw);
            alert('Error del servidor. Revisa la consola.');
        }
    })
    .catch(err => console.error('Error RFQ:', err));
}

function sendRFQ() {
    const suppliers = document.querySelectorAll('#rfqSuppliersList input[type=checkbox]:checked');
    if (!suppliers.length) { alert('Selecciona proveedores'); return; }

    const formData = new FormData();
    formData.append('quote_id', document.getElementById('operation_id').value);
    suppliers.forEach(cb => formData.append('suppliers[]', cb.value));
    selectedItems.forEach(id => formData.append('items[]', id));

    fetch('index.php?page=rfq&action=create', { method: 'POST', body: formData })
        .then(r => r.text())
        .then(raw => {
            console.log('create response:', raw);
            alert('RFQ generado');
            location.reload();
        })
        .catch(err => console.error('Error sendRFQ:', err));
}
</script>

<style>
.customer-data {
    line-height: 0.80; /* Ajusta el espacio entre líneas */
    min-height: 20px; /* Evita que el párrafo sea demasiado pequeño */
    margin: 0; /* Elimina márgenes extra */
    padding: 5px 0; /* Espaciado interno opcional */
}

.table-container {
    width: 90%; /* Usa el ancho completo */
    max-width: 100%; /* Previene desbordamiento horizontal */
    overflow-x: auto; /* Activa scroll horizontal solo si es necesario */
    margin: 0 auto;
}

.customer-table {
    width: 90%; /* Ancho completo dentro del contenedor */
    max-width: 90%; /* Asegura que no desborde */
    border-collapse: collapse;
    margin: 0 auto;
    word-wrap: break-word; /* Envuelve contenido largo */
    margin: 0 auto 20px auto;
}
        .container {
            text-align: center; /* Centra el contenido del contenedor */
            width: 100%; /* Ajusta el ancho del contenedor */
        }
        
        .container img {
            display: block; /* Necesario para que margin auto funcione correctamente */
            margin: 0 auto; /* Centra la imagen horizontalmente */
            width: 50%; /* Ajusta el ancho de la imagen */
        }
        
        th, td {
            border: 1px solid #ccc; /* Borde alrededor de las celdas */
            padding: 10px; /* Espacio dentro de las celdas */
            /* text-align: right;  Centra el texto dentro de las celdas */
        }
        
        
.quote-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed; /* imprescindible para anchos fijos */
    margin: 0 auto;
}

.quote-table th,
.quote-table td {
    border: 1px solid #ccc;
    padding: 8px;
}

.quote-table th {
    background-color: orangered;
    color: white;
    font-weight: 600;
}

.col-concept {
    width: 25%;
    text-align: left;
    font-weight: 500;
}

.col-number {
    width: 10%;
    text-align: right;
    font-size: 0.9em; /* números más pequeños */
}

.quote-input {
    width: 100%;
    padding: 4px;
    text-align: right;
    border: none;
    font-size: 0.9em;
}

.note-input {
    width: 100%;
    padding: 4px;
    text-align: left;
    height: 30px;
    border: none;
    font-size: 0.9em;
}


        .item input {
            height: 100%;
            width: 100%;
            padding: 0px;
            text-align: right;
            border: none;
        }
    
        .events {
            padding-top: 20px;
            display: flex;
            gap: 10px;
        }
      
#stripeModal div {
    width: 90%;
    max-width: 600px;
}

@media (max-width: 768px) {
    #stripeModal div {
        width: 95%;
    }
}

</style>