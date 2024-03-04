<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use Resend;

class Email{
    public $nombre;
    public $email;
    public $token;

    // Constructor
    public function __construct($nombre,$email,$token){
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }

    // Enivar confirmación del email
    public function enviarConfirmacion(){
        // Crear el objeto de email
        /*$mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        // Configurar el contenido del email
        $mail->setFrom('info@larabel.com');
        $mail->addAddress($this->email,$this->nombre);
        $mail->Subject = 'Confirma tu cuenta';

        // Habilitar HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        // Definir el contenido
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en LaraBel Centro de Estética, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // Enviar el email
        $mail->send();*/
        $resend = Resend::client('re_5x1UfH6x_LNeFByjwm5t8g9WQWLU8p8cN');
        
        $resend->emails->send([
            'from' => 'onboarding@resend.dev',
            'to' => $this->email,
            'subject' => 'Confirma tu cuenta',
            'html' => "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en LaraBel Centro de Estética, solo debes confirmarla presionando el siguiente enlace</p>".
                    "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>".
                    "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>"
        ]);
    }

    public function enviarInstrucciones(){
        // Crear el objeto de email
        /*$mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        // Configurar el contenido del email
        $mail->setFrom('cuentas@larabel.com');
        $mail->addAddress($this->email,$this->nombre);
        $mail->Subject = 'Reestablece tu contraseña';

        // Habilitar HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        // Definir el contenido
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestablecer tu contraseña, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Reestablecer Contraseña</a></p>";
        $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // Enviar el email
        $mail->send();*/
        $resend = Resend::client('re_5x1UfH6x_LNeFByjwm5t8g9WQWLU8p8cN');
        
        $resend->emails->send([
            'from' => 'onboarding@resend.dev',
            'to' => $this->email,
            'subject' => 'Reestablece tu contraseña',
            'html' => "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestablecer tu contraseña, sigue el siguiente enlace para hacerlo.</p>".
            "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Reestablecer Contraseña</a></p>".
            "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>"
        ]);
    }
}