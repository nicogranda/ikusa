<?php

namespace App\Domains\Leads;

require_once '../app/config/connection.php';

class SEOLeadController
{
    private $mysqli;

    public function __construct()
    {
        global $mysqli;

        $this->mysqli = $mysqli;
    }

    public function create()
    {
        include '../app/views/leads/create.php';
    }

    public function store()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            header('Location: /?page=lead&action=create');
            exit;

        }

        // Honeypot
        if (!empty($_POST['website_fake'])) {

            die('Spam detectado');

        }

        // Datos
        $name = trim($_POST['name'] ?? '');

        $email = trim($_POST['email'] ?? '');

        $website = trim($_POST['website'] ?? '');

        $message = trim($_POST['message'] ?? '');

        // Validaciones
        if (
            empty($name) ||
            empty($email)
        ) {

            die('Faltan campos obligatorios');

        }

        // Sanitizar
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

        $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

        $website = htmlspecialchars($website, ENT_QUOTES, 'UTF-8');

        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        $message_html = nl2br($message);

        /*
        |--------------------------------------------------------------------------
        | VARIABLES MAIL (MISMO ESTILO QUE TU MAILCONTROLLER)
        |--------------------------------------------------------------------------
        */

        $mailerId = 'Ikusa';

        $mailerTo = 'ikusa.ads@gmail.com';

        $mailerFrom = 'contact@ikusa.net';

        $mailerToToo = 'ikusa.ads@gmail.com';

        $mailerReplay = $email;

        $subject = 'Nueva solicitud de auditoría SEO';

        $business = $website;

        $representative = $name;

        $greeting_message = "

            Hola <b>{$name}</b>,

            <br><br>

            Hemos recibido una nueva solicitud de auditoría SEO.

            <br><br>

            <b>Nombre:</b><br>
            {$name}

            <br><br>

            <b>Email:</b><br>
            {$email}

            <br><br>

            <b>Sitio web:</b><br>
            {$website}

            <br><br>

            <b>Objetivo SEO:</b><br>
            {$message_html}

        ";

        $farewell_message = "
            Gracias por contactar con Ikusa.
        ";

        $signatory = 'Ikusa';

        $signatory_position = 'SEO & Development';

        /*
        |--------------------------------------------------------------------------
        | EMAIL TEMPLATE
        |--------------------------------------------------------------------------
        */

        require_once '../app/config/email.php';

        include dirname(__DIR__, 4) . '/app/src/Domains/Admin/Email/views/mail.php';

        require_once '../app/libraries/inc_phpmailer.php';

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        header('Location: /?page=lead&action=success');

        exit;

    }

    public function success()
    {
        include '../app/views/leads/success.php';
    }
}