<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
    protected $email;
    protected $name;
    protected $token;

    public function __construct($email, $name, $token)
    {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    public function sendConfirmation()
    {
        $phpmailer = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $phpmailer->isSMTP();
            $phpmailer->Host = 'smtp.gmail.com';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Username = 'adelacruzsu@unprg.edu.pe';
            $phpmailer->Password = 'taxporV3rGA4$xD';
            $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $phpmailer->Port = 587;

            // Remitente y destinatario
            $phpmailer->setFrom('adelacruzsu@unprg.edu.pe', 'TaskMapp');
            $phpmailer->addAddress($this->email, $this->name);

            // Asunto y cuerpo del mensaje
            $phpmailer->Subject = 'Confirm your account';

            $phpmailer->isHTML(true);
            $phpmailer->CharSet = 'UTF-8';

            $content = '<html>';
            $content .= "<p><strong>Hola " . $this->name . "</strong>, has creado tu cuenta en TaskMapp. Solo debes confirmar tu cuenta haciendo clic en el enlace.</p>";
            $content .= "<p>Haz clic aquí: <a href='". $_ENV['APP_URL'] ."/confirm?token=" . $this->token . "'>Confirmar cuenta</a></p>";
            $content .= "<p>Si tú no creaste esta cuenta, ignora este mensaje.</p>";
            $content .= '</html>';

            $phpmailer->Body = $content;

            // Enviar email
            $phpmailer->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$phpmailer->ErrorInfo}";
        }
    }


    public function sendInstructions()
    {
        $phpmailer = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $phpmailer->isSMTP();
            $phpmailer->Host = $_ENV['EMAIL_HOST'];
            $phpmailer->SMTPAuth = true;
            $phpmailer->Username = $_ENV['EMAIL_USER'];
            $phpmailer->Password = $_ENV['EMAIL_PASS'];
            $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $phpmailer->Port = $_ENV['EMAIL_PORT'];

            // Remitente y destinatario
            $phpmailer->setFrom('adelacruzsu@unprg.edu.pe', 'ManageTask');
            $phpmailer->addAddress($this->email, $this->name);

            // Asunto y cuerpo del mensaje
            $phpmailer->Subject = 'Rerstablece tu cuenta';

            $phpmailer->isHTML(true);
            $phpmailer->CharSet = 'UTF-8';

            $content = '<html>';
            $content .= "<p><strong>Hola " . $this->name . "</strong>, has solicitado restableer tu cuenta en TaskMapp. Solo debes confirmar tu cuenta haciendo clic en el enlace.</p>";
            $content .= "<p>Haz clic aquí: <a href='". $_ENV['APP_URL'] ."/reset?token=" . $this->token . "'>restablece cuenta</a></p>";
            $content .= "<p>Si tú no creaste esta cuenta, ignora este mensaje.</p>";
            $content .= '</html>';

            $phpmailer->Body = $content;

            // Enviar email
            $phpmailer->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$phpmailer->ErrorInfo}";
        }
    }
}
