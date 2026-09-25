<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class MailController {

    public function create() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isset($_POST['message_id'])) {
                echo "Falta el ID del mensaje.";
                return;
            }

            $mailerId = 'Ikusa';

            $mailerTo = trim($_POST['mailerTo'] ?? '');
            $mailerFrom = 'contact@ikusa.net';
            $mailerToToo = 'ikusa.ads@gmail.com';
            $mailerReplay = $mailerFrom;
            
            $subject = trim(($_POST['subject'] ?? ''));
            
            $business = htmlspecialchars(trim($_POST['business_name'] ?? ''), ENT_QUOTES, 'UTF-8');
            $representative = $_POST['representative'];
            
            $message = $_POST['message'] ?? '';
            $message_html = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));

            // Valores por defecto
            $greeting_message = '';
            $farewell_message = 'Saludos cordiales';


            switch ($_POST['message_id']) {


                case 'information':

                    $greeting_message = 
                    "Hola <b>{$representative}</b>, recibe un cordial saludo con la presente, por medio de la cual:<br><br>"
                    . $message_html;

                    $farewell_message = 
                    "Agradeciendo su acostumbrada receptividad, nos despedimos";

                    break;



                case 'final_artwork':

                    $campaign = $_POST['campaign'] ?? '';

                    $greeting_message = 
                    "Hola <b>{$representative}</b>, con la presente hacemos entrega de Final Artwork sobre <b>{$campaign}</b>";

                    $farewell_message = 
                    "Agradeciendo su confianza en nuestras propuestas de diseños, nos despedimos";

                    break;



                case 'rfq':

                    $greeting_message =
                    "Hola <b>{$representative}</b>, con la presente hacemos solicitud de precios para la impresión de:<br><br>"
                    . $message_html;

                    $farewell_message =
                    "Agradeciendo su acostumbrada receptividad, nos despedimos";

                    break;



                case 'print_request':

                    $greeting_message =
                    "Hola <b>{$representative}</b>, con la presente hacemos solicitud para la impresión de:<br><br>"
                    . $message_html;

                    $farewell_message =
                    "Agradeciendo su acostumbrada receptividad, nos despedimos";

                    break;



                case 'document_transmittal':

                    $campaign = $_POST['campaign'] ?? '';

                    $greeting_message =
                    "Hola <b>{$representative}</b>, con la presente adjuntamos lo indicado en el asunto, sobre <b>{$campaign}</b><br>";

                    $farewell_message =
                    "Agradeciendo su confianza en nuestras propuestas, nos despedimos";

                    break;



                // case 'company_information':


                //     $section_es  = "<hr><h3>Informaci&oacute;n de la Empresa</h3>";
                //     $section_es .= "Estimado/a <b>{$representative}</b>,<br><br>";
                //     $section_es .= "A continuación encontrará los <b>datos corporativos</b> e información bancaria de nuestra empresa necesarios para la formalización del contrato:<br>";
                    
                //     $section_es .= "<br><b>Nombre de Empresa:</b> Ikusa LLC";
                //     $section_es .= "<br><b>Dirección Registrada:</b> 8735 Dunwoody Place, Ste R, Atlanta, GA 30350, United States";
                //     $section_es .= "<br><b>Teléfono / WhatsApp España:</b> +34 600 14 26 63";
                //     $section_es .= "<br><b>ID Fiscal / CIF:</b> EIN: 87-2680481";
                //     $section_es .= "<br><b>Datos Bancarios (Wise):</b> IBAN: BE82 9678 2700 3168";
                //     $section_es .= "<br><b>Datos Bancarios (Bank of America):</b> Cuenta: 334070489489, Routing: 061000052, SWIFT: BOFAUS6S";
                //     $section_es .= "<br><b>Representante Legal:</b> Nicol&aacute;s Granda Bauza";
                //     $section_es .= "<br><b>Cargo:</b> Manager";
                //     $section_es .= "<br><b>ID:</b> NIE Z0773740W";
                    
                //     $section_es .= "<br><br>Quedamos a su disposición para cualquier otro requerimiento legal o administrativo.<br>";


                case 'company_information':

      
                    $section_es  = "<hr><h3>Informaci&oacute;n de la Empresa</h3>";
                    $section_es .= "Estimado/a <b>{$representative}</b>,<br><br>";
                    $section_es .= "A continuaci&oacute;n encontrar&aacute; los <b>datos corporativos</b> e informaci&oacute;n bancaria de nuestra empresa necesarios para la formalizaci&oacute;n del contrato:<br>";
                
                    $section_es .= "<br><b>Nombre de Empresa:</b> Ikusa LLC";
                    $section_es .= "<br><b>Direcci&oacute;n Registrada:</b> 8735 Dunwoody Place, Ste R, Atlanta, GA 30350, United States";
                    $section_es .= "<br><b>Tel&eacute;fono / WhatsApp Espa&ntilde;a:</b> +34 600 14 26 63";
                    $section_es .= "<br><b>ID Fiscal / CIF:</b> EIN: 87-2680481";
                    $section_es .= "<br><b>Datos Bancarios (Wise):</b> IBAN: BE82 9678 2700 3168";
                    $section_es .= "<br><b>Datos Bancarios (Bank of America):</b> Cuenta: 334070489489, Routing: 061000052, SWIFT: BOFAUS6S";
                    $section_es .= "<br><b>Representante Legal:</b> Nicol&aacute;s Granda Bauza";
                    $section_es .= "<br><b>Cargo:</b> Manager";
                    $section_es .= "<br><b>ID:</b> NIE Z0773740W";
                
                    $section_es .= "<br><br>Quedamos a su disposici&oacute;n para cualquier otro requerimiento legal o administrativo.<br>";

                    $section_en  = "";
                    
                    // $section_en  = "<hr><h3>Company Information</h3>";
                    // $section_en .= "Dear <b>{$representative}</b>,<br><br>";
                    // $section_en .= "Please find below our company's <b>corporate details</b> and banking information required for contract formalization:<br>";

                    // $section_en .= "<br><b>Business Name:</b> Ikusa LLC";
                    // $section_en .= "<br><b>Registered Address:</b> 8735 Dunwoody Place, Ste R, Atlanta, GA 30350, United States";
                    // $section_en .= "<br><b>Phone / WhatsApp Spain:</b> +34 600 14 26 63";
                    // $section_en .= "<br><b>Tax ID:</b> EIN: 87-2680481";
                    // $section_en .= "<br><b>Bank Details (Wise):</b> IBAN: BE82 9678 2700 3168";
                    // $section_en .= "<br><b>Bank Details (Bank of America):</b> Account: 334070489489, Routing: 061000052, SWIFT: BOFAUS6S";
                    // $section_en .= "<br><b>Legal Representative:</b> Nicolas Granda Bauza";
                    // $section_en .= "<br><b>Title:</b> Manager";
                    // $section_en .= "<br><b>ID:</b> NIE Z0773740W";

                    // $section_en .= "<br><br>We remain at your disposal for any further legal or administrative requirements. Best regards";


                    $greeting_message = $section_es . $section_en;

                    $farewell_message = 
                    "Saludos cordiales";

                    break;



                default:

                    $greeting_message = $message_html;

                    $farewell_message =
                    "Saludos cordiales";

                    break;
            }



            $signatory = isset($_SESSION['user_name']) 
                ? htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8') 
                : "Nombre por defecto";


            $signatory_position = "";


            require_once __DIR__ . '/../../config/email.php';


            require_once __DIR__ . '/../../views/admin/E-mail/mail.php';


            require_once __DIR__ . '/../../libraries/inc_phpmailer.php';


            require_once __DIR__ . '/../../views/admin/E-mail/notice.php';



        } else {

            require_once __DIR__ . '/../../views/admin/E-mail/create.php';

        }
    }
}