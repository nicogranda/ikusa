<?php
$googleClientId = (string) ($_ENV['GOOGLE_CLIENT_ID'] ?? '');
$googleCsrf = (string) ($_SESSION['google_login_csrf'] ?? '');
?>
<div id="g_id_onload"
     data-client_id="<?= htmlspecialchars($googleClientId, ENT_QUOTES, 'UTF-8') ?>"
     data-callback="handleGoogleCredentialResponse"
     data-auto_prompt="false"></div>
<div class="g_id_signin"
     data-type="standard"
     data-size="large"
     data-theme="outline"
     data-text="sign_in_with"
     data-shape="rectangular"
     data-logo_alignment="left"></div>

<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
window.handleGoogleCredentialResponse = async function (response) {
    if (!response || !response.credential) {
        alert('Google no entregó un token de acceso.');
        return;
    }

    try {
        const result = await fetch(<?= json_encode(route_url('admin'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': <?= json_encode($googleCsrf, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>
            },
            body: JSON.stringify({credential: response.credential})
        });
        const data = await result.json();
        if (result.ok && data.success) {
            window.location.assign(data.redirect);
        } else {
            alert(data.error || 'No se pudo iniciar sesión con Google.');
        }
    } catch (error) {
        alert('No se pudo conectar con el servidor de acceso.');
    }
};
</script>
