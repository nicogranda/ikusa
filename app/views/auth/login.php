<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<main>
    Identifiquese
    <form method="post" action="index.php?page=identify" id="emailForm">
        <input 
            type="email" 
            name="email" 
            id="email" 
            placeholder="E-mail" required>
        <input 
            type="hidden" 
            name="page" 
            id="page"
            value="<?php echo $page;?>" />  
        <div id="error-message" style="color: red; display: none;">El formato de E-mail no es válido.</div>
        <button type="submit" id="submitButton">Ingresar</button>
    </form>

<div style="text-align:center">---------------- o ---------------</div>
  
<!--<div id="g_id_onload"-->
<!--     data-client_id="<?= //$_ENV['GOOGLE_CLIENT_ID'] ?>"-->
<!--     data-callback="handleGoogleCredentialResponse"-->
<!--     data-auto_prompt="false">-->
<!--</div>-->

<div id="g_id_onload"
     data-client_id="<?= $_ENV['GOOGLE_CLIENT_ID'] ?>"
     data-callback="handleGoogleCredentialResponse"
     data-auto_prompt="false"
     data-scope="openid email profile">
</div>

<div class="g_id_signin"
     data-type="standard"
     data-size="large"
     data-theme="outline"
     data-text="sign_in_with"
     data-shape="rectangular"
     data-logo_alignment="left">
</div>
</main>

<!-- Cliente de Google -->
<script src="https://accounts.google.com/gsi/client" async defer></script>

<script>
console.log("Google Client ID:", "<?= $_ENV['GOOGLE_CLIENT_ID'] ?>");

  window.handleGoogleCredentialResponse = function(response) {
    console.log("Respuesta de Google:", response);

  fetch('/api/login-google.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'include',
      body: JSON.stringify({ credential: response.credential })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        localStorage.setItem('userName', data.user.name);
        localStorage.setItem('user_id', data.user.id);
        window.dispatchEvent(new Event('userLogin'));
    
        // Redireccionar según el rol
        const role = data.user.role;
        if (role === 'admin') {
          window.location.href = 'index.php?page=admin&action=index';
        } else {
          window.location.href = 'index.php?page=enroll';
        }
      } else {
        alert('Login fallido.');
      }
    })
    .catch(() => {
      alert('Error al autenticar con Google.');
    });

  };
</script>

<script>
    // Referencias al formulario y al campo de E-mail
    const emailInput = document.getElementById('email');
    const errorMessage = document.getElementById('error-message');
    const form = document.getElementById('emailForm');

    form.addEventListener('submit', function (event) {
        // Patrón para validar el formato de E-mail
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Verifica si el E-mail es válido
        if (!emailPattern.test(emailInput.value)) {
            // Evita que se envíe el formulario
            event.preventDefault();

            // Muestra el mensaje de error
            errorMessage.style.display = 'block';
        } else {
            // Oculta el mensaje de error si el formato es correcto
            errorMessage.style.display = 'none';
        }
    });
</script>


