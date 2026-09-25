<div class="container-form">

<form method="POST" action="index.php?page=admin&action=auth">

    <img src="../../../../assets/img/logo.png" alt="Ikusa" class="logo">

    <?php if (isset($_SESSION['error'])): ?>
        <p class="error-message">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </p>
    <?php endif; ?>

    <input 
        type="text" 
        name="username" 
        placeholder="Usuario"
        class="form-input"
        autocomplete="username"
    >

    <input 
        type="password" 
        name="password" 
        placeholder="Contraseña"
        class="form-input"
        autocomplete="current-password"
    >

    <button type="submit" class="button-primary">
        Ingresar
    </button>


    <div class="links">
        <a href="forgot-password.php">
            ¿Olvidaste tu contraseña?
        </a>

        <a href="register.php">
            Regístrate
        </a>
    </div>


    <div class="links google-login">
        <?php include __DIR__ . '/../../components/login_google.php'; ?>
    </div>

</form>

</div>

<style>
    .container-form {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    background: #f5f6fa;
    box-sizing: border-box;
}
.container-form form {
    width: 100%;
    max-width: 420px;
    background: #ffffff;
    padding: 45px 40px;
    border-radius: 18px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    gap: 18px;
}
.logo {
    width: 150px;
    height: auto;
    margin: 0 auto 25px;
    display: block;
}
.form-input {
    width: 100%;
    padding: 14px 16px;
    border: 1px solid #ddd;
    border-radius: 10px;
    font-size: 15px;
    background: #fafafa;
    transition: all .3s ease;
    box-sizing: border-box;
}
.form-input:focus {
    outline: none;
    border-color: #111;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(0,0,0,.08);
}
.button-primary {
    margin-top: 10px;
    padding: 14px;
    border: none;
    border-radius: 10px;
    background: #111;
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all .3s ease;
}
.button-primary:hover {
    background: #333;
    transform: translateY(-1px);
}
.error-message {
    background: #ffe7e7;
    color: #c62828;
    padding: 12px 15px;
    border-radius: 8px;
    font-size: 14px;
    text-align: center;
}
.links {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 10px;
    flex-wrap: wrap;
}
.links a {
    color: #555;
    text-decoration: none;
    font-size: 14px;
    transition: color .2s ease;
}
.links a:hover {
    color: #000;
}
/* Google login */
.links:last-child {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}
</style>