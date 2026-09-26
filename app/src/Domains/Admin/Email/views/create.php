<main class="container">
    
    <form action="" method="post" id="f1" name="f1" enctype="multipart/form-data" onsubmit="return validacion()">
        
        <!-- Message selector -->
        <select name="message_id" id="message_id" onchange="toggleMessageTextarea()" class='item'>
            <option value="">Select</option>
        
            <option value="company_information">Company Information</option>
            <option value="layout">Layout</option>
            <option value="final_artwork">Final Artwork</option>
            <option value="information">Information</option>
            <option value="rfq">Request for quote (RFQ)</option>
            <option value="print_request">Print request</option>
            <option value="document_transmittal">Document Transmittal</option>
        </select>
            
        <!-- Sender's Email input -->
        <input type="email" name="senderEmail" id="senderEmail" placeholder="Sender Email" value="contact@ikusa.net" readonly class='item'>

        <!--alias input -->
        <input type="text" name="alias" id="alias" placeholder="Alias" onblur="search();" class="input-field">
 
        <!-- Business input -->
        <input type="text" name="business_name" id="businessName" placeholder="Business">
        
        <!-- Email input -->
        <input type="email" name="mailerTo" id="email" placeholder="Email" class='item'>
        <div id='alertemail' style='display:none;' class="alert">E-mail</div>

        <!-- Representative input -->
        <input type="text" name="representative" id="representative" placeholder="Representative" class='item'>
        
        <!-- Subject input -->
        <input type="text" name="subject" id="subject" placeholder="Subject" class='item'>
        <div id='alertsubject' style='display:none;' class="alert">Subject</div>
        
        <!-- Campaign input -->
        <input type="text" name="campaign" id="campaign" placeholder="Campaign" class='item'>
        <div id='campaign' style='display:none;' class="alert">Show campaign name</div>
        
 
        <!--Message-->
        <div id='alertdate' style='display:none; width:100%' class="alert">Show Message</div>
        
        <!-- Preview del mensaje -->
        <div id="messagePreview" style="display:none; background:#f9f9f9; border:1px solid #ddd; border-radius:4px; padding:12px; margin: 5px 0; font-size:14px; color:#444; line-height:1.5;"></div>

        <!-- Textarea without TinyMCE -->
        <div class='item' id="messageContainer" style='display: none;'>
            <textarea name="message" id="message" rows="5" cols="50" placeholder="Enter your message here"></textarea>
        </div>
    
        <!-- File input -->
        <!--<input type="file" name="attachment[]" multiple title="Attachment" class='item'>-->
        <div style="padding: 0px 0 20px 0;">
            <label for="fileUpload" class="custom-file-upload">Adjuntar archivo</label>
            <input type="file" id="fileUpload" name="attachment[]" multiple title="Attachment" class='item'>
            <span id="file-name">Ningún archivo seleccionado</span> <!-- Aquí se mostrarán los archivos -->
        </div>
        
        <!-- Submit button -->
        <input type="submit" name="send" id="send" value="Send" class="button-principal">
    
    </form>
</main>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const sendBtn = document.getElementById("send");
    sendBtn.disabled = true;

    const inputs = ["email", "subject", "campaign", "message_id"];

    inputs.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener("input", validarFormulario);
            el.addEventListener("change", validarFormulario);
        }
    });

    // File upload
    const fileUpload = document.getElementById('fileUpload');
    if (fileUpload) {
        fileUpload.addEventListener('change', function () {
            let fileName = this.files.length > 0
                ? Array.from(this.files).map(f => f.name).join(', ')
                : "Ningún archivo seleccionado";

            document.getElementById('file-name').textContent = fileName;
        });
    }

    // Message toggle
    const messageSelect = document.getElementById('message_id');
    if (messageSelect) {
        messageSelect.addEventListener("change", toggleMessageTextarea);
    }

    function toggleMessageTextarea() {

        const value = document.getElementById('message_id').value;

        const messageContainer = document.getElementById('messageContainer');
        const messagePreview = document.getElementById('messagePreview');

        // =========================
        // MAPPING CORRECTO (NUEVOS IDS)
        // =========================
        const previews = {
            'information': 'Hola [Representative], recibe un cordial saludo con la presente, por medio de la cual:',
            'final_artwork': 'Hola [Representative], con la presente hacemos entrega de Final Artwork sobre [Campaign]',
            'rfq': 'Hola [Representative], con la presente hacemos solicitud de precios para la impresión de:',
            'print_request': 'Hola [Representative], con la presente hacemos solicitud para la impresión de:',
            'document_transmittal': 'Hola [Representative], con la presente adjuntamos lo indicado en el asunto, sobre [Campaign]',
            'company_information': 'Estimado/a [Representative], a continuación encontrará los datos corporativos e información bancaria...'
        };

        if (previews[value]) {
            messagePreview.style.display = 'block';
            messagePreview.innerText = previews[value];
        } else {
            messagePreview.style.display = 'none';
        }

        // =========================
        // MOSTRAR TEXTAREA SOLO DONDE APLICA
        // =========================
        const showTextareaFor = ['information', 'print_request', 'rfq'];

        if (showTextareaFor.includes(value)) {
            messageContainer.style.display = 'block';
        } else {
            messageContainer.style.display = 'none';
        }

        validarFormulario();
    }

    function validarFormulario() {

        let email = document.getElementById('email').value.trim();
        let subject = document.getElementById('subject').value.trim();
        let message_id = document.getElementById('message_id').value;

        let valid = true;

        if (email === "") {
            document.getElementById('alertemail').style.display = 'block';
            document.getElementById('alertemail').innerText = 'El email no puede estar vacío';
            valid = false;
        } else {
            document.getElementById('alertemail').style.display = 'none';
        }

        if (subject === "") {
            document.getElementById('alertsubject').style.display = 'block';
            document.getElementById('alertsubject').innerText = 'El asunto no puede estar vacío';
            valid = false;
        } else {
            document.getElementById('alertsubject').style.display = 'none';
        }

        if (message_id === "") {
            valid = false;
        }

        sendBtn.disabled = !valid;
    }

    // inicial
    toggleMessageTextarea();
});
function search() {

    const alias = document.getElementById('alias').value.trim();
    const message_id = document.getElementById('message_id').value;

    if (!alias) return;

    // IMPORTANTE: ahora usa IDs nuevos
    const rfqTypes = ['rfq'];

    const type = rfqTypes.includes(message_id) ? 'supplier' : 'client';

    fetch(`index.php?page=messaging&action=lookup&alias=${encodeURIComponent(alias)}&type=${encodeURIComponent(type)}`)
        .then(response => response.json())
        .then(data => {

            if (data.success) {

                document.getElementById('businessName').value =
                    data.data.name ?? '';

                document.getElementById('email').value =
                    data.data.email ?? '';

                document.getElementById('representative').value =
                    data.data.representative ?? '';

            } else {
                console.warn(data.message);
            }

        })
        .catch(error => {
            console.error('Error fetching supplier/client:', error);
        });
}
</script>

<style>
.custom-file-upload {
    display: inline-block;
    background-color: #F15A24; /* Anaranjado */
    color: white;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    font-family: var(--font-primary, sans-serif);
}
.custom-file-upload:hover {
    background-color: #D94E1F; /* Un poco más oscuro */
}
input[type="file"] {
    display: none;
}


/* Style for the form items */
form .item {
    margin-bottom: 15px;
}

/* Input fields styling */

input[type="email"],
input[type="file"],
input[type="text"],
select,
textarea {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;  /* ← añade esta línea */
}

/* Placeholder styles */
input::placeholder, textarea::placeholder {
    color: #888;
}

/* Submit button styles */
input[type="submit"] {
    background-color: #F15A24; /* Using your primary color */
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 16px;
    width: 100%; /* Makes the submit button take full width of the container */
}

/* Hover effect for the submit button */
input[type="submit"]:hover {
    background-color: #e14e18; /* Darken color for hover effect */
}

/* Alert message styling */
.alert {
    color: red;
    font-size: 12px;
    display: none;
}

/* Responsive Design */
@media (max-width: 600px) {
    /*.container-form {*/
       /* width: 90%; /* Make the container smaller on mobile */
    /*    padding: 15px;*/
    /*}*/

  
    }
}

</style>