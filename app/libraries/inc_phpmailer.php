 <?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

/* Clase para tratar con excepciones y errores */
require 'PHPMailer/src/Exception.php';
/* Clase PHPMailer */
require 'PHPMailer/src/PHPMailer.php';
/* Clase SMTP necesaria para conectarte a un servidor SMTP */
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {

    // Charset antes de configurar remitentes
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    
    //Server settings
   //$mail->SMTPDebug = SMTP::DEBUG_SERVER;    //Enable verbose debug output
    $mail->isSMTP();                             //Send using SMTP
    $mail->Host       = $host;                   //Set the SMTP server to send through
    $mail->SMTPAuth   = $SMTPAuth;               //Enable SMTP authentication
    $mail->Username   = $Username;               //SMTP username
    $mail->Password   = $Password;                //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $Port ;                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($mailerFrom,$mailerId);
    $mail->addAddress($mailerTo);                   //Add a recipient
    $mail->addAddress($mailerToToo);                //Name is optional
    $mail->addReplyTo($mailerReplay);
    $mail->addCC($mailerFrom);
    // $mail->addBCC('bcc@example.com'); 

    // Directorio donde se guardarè°©n los archivos subidos
    $uploadDir = 'uploads/';

    // Asegurate de que el directorio de subida exista y sea escribible
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
     // Procesar los archivos subidos
        if (isset($_FILES['attachment']) && !empty($_FILES['attachment']['name'][0])) {
            foreach ($_FILES['attachment']['tmp_name'] as $key => $tmpName) {
                $fileName = basename($_FILES['attachment']['name'][$key]);
                $targetFilePath = $uploadDir . $fileName;
        
                // Mover el archivo subido a la ubicaciÃ³n deseada
                if (move_uploaded_file($tmpName, $targetFilePath)) {
                    // Adjuntar el archivo al correo
                    $mail->addAttachment($targetFilePath);
                }
            }
    }

    
    $mail->isHTML(true); // Set email format to HTML

    // Procesar el contenido del mensaje
    //$body = nl2br($message); // Convierte saltos de l¨ªnea en <br>
    
    // Reemplazar **texto** por <b>texto</b> (negritas estilo Markdown)
    $body = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $body);
    
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body); // Versi¨®n sin HTML para clientes que no soportan HTML
    
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
    $mail->send();
    $mailSentSuccessfully = true;
    $_SESSION['status'] = "Envio exitoso";

} catch (Exception $e) {

    $mailSentSuccessfully = false;
    error_log("PHPMailer Error: {$mail->ErrorInfo}");

}