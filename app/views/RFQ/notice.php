<head>
    <meta charset="UTF-8">
    <title>Email Enviado</title>

    <link rel="stylesheet" href="css/email.css" type="text/css" charset="utf-8" />

    <style>

        .email-success-wrapper {
            min-height: 60vh;
            margin-top: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }


        .form-container {
            width: 100%;
            max-width: 600px;
            background: #ffffff;
            padding: 45px;
            border-radius: 16px;
            box-sizing: border-box;
            box-shadow: 0 15px 40px rgba(0,0,0,.08);
            text-align: center;
            border-top: 5px solid var(--color-primary);
        }


        .success-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 25px;
            border-radius: 50%;
            background: var(--color-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            font-weight: bold;
        }


        .form-container h2 {
            margin-bottom: 20px;
            font-size: 30px;
            color: #222;
        }


        .item-sent {
            margin-bottom: 18px;
            color: #555;
            font-size: 16px;
            line-height: 1.6;
        }


        .item-sent strong {
            color: #222;
        }


        .spam-message {
            margin: 30px 0;
            padding: 15px 20px;
            background: #f7f7f7;
            border-left: 4px solid var(--color-primary);
            border-radius: 8px;
            text-align: left;
            font-size: 15px;
            color: #555;
        }


        .return-link {
            display: inline-block;
            background: var(--color-primary);
            color: #fff;
            padding: 14px 35px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 17px;
            font-weight: 600;
            transition: .3s ease;
        }


        .return-link:hover {
            opacity: .85;
            transform: translateY(-2px);
        }


    </style>

</head>


<div class="email-success-wrapper">

    <div class="form-container">


        <div class="success-icon">
            ✓
        </div>


        <div class="item-sent">
            <h2>Email Enviado</h2>
        </div>


        <div class="item-sent">

            <p>
                Hemos enviado un email a:
                <br>
                <strong>
                    <?= htmlspecialchars($mailerTo); ?>
                </strong>
            </p>

        </div>


        <div class="item-sent">

            <p>
                Desde el correo:
                <br>
                <strong>
                    <?= htmlspecialchars($mailerFrom); ?>
                </strong>
            </p>

        </div>


        <div class="spam-message">

            Si no recibes el correo en unos minutos, 
            revisa tu carpeta de <strong>spam o correo no deseado</strong>.
            
            También verifica que la dirección introducida sea correcta.

        </div>


        <div class="item-sent">

            <a href="/" class="return-link">
                Volver al inicio
            </a>

        </div>


    </div>

</div>