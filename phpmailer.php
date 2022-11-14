<?php
// Importar clases PHPMailer en el espacio de nombres global 
// Estas deben estar en la parte superior de su script, no dentro de una función
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'assets/vendor/phpmailer/src/PHPMailer.php';
require 'assets/vendor/phpmailer/src/Exception.php';
require 'assets/vendor/phpmailer/src/SMTP.php';


// El cargador automático de Load Composer 
require 'assets/vendor/autoload.php';

    // Crea una instancia; pasar `true` habilita excepciones 
   // $mail = new PHPMailer( true );

class Mail {
    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function

    public function __construct() {

    }



    function enviar_email($de, $contacto, $para, $usuario, $titulo, $mensaje) {
        // Asignar configuracion SMTP
        //$hostsmtp = 'in-v3.mailjet.com';
        //$username = '69ab5f937892f303ec2e15850eab226a';
        //$password = '72bedbff369fb3efc4e5693a702ed56d';
        $hostsmtp = 'mail.redpbm.org';
        $username = 'cuestionarios@redpbm.org';
        $password = 'RedPBM2021.';/*
        $de = 'ejemplo@gmail.com';
        $contacto = 'contacto Red PbM';
        $para = 'ejemplo@gmail.com';
        $usuario = 'Estimado usuario';
        $titulo =  'Contacto desde la web';
        $mensaje = 'contacto@dominio.org';*/

       // $resp = "";
        // Crea una instancia; pasar `true` habilita excepciones 

     //   $mail = new PHPMailer\PHPMailer\PHPMailer(true); // Passing `true` enables exceptions
        try {
            $mail = new PHPMailer( true );
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            //Server settings
            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = 0; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = $hostsmtp; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = $username; // SMTP username
            $mail->Password = $password; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // TCP port to connect to

            //Remitente
            $mail->setFrom($de, $contacto);
            //Destinatario/a
            $mail->addAddress($para, $usuario); 
            $mail->SMTPKeepAlive = true;  
           // $mail->Mailer = "smtp"; 

            //Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $titulo;
            $mail->Body = $mensaje;

            // Enviar correo
            $mail->send();

            echo 'El correo ha sido enviado exitosamente!';
        } catch (Exception $e) {
            echo 'Hubo un error al enviar el mensaje: ', $mail->ErrorInfo;
        }
    }
}
?>
