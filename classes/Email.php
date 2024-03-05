<?php

namespace Classes;

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

    // Enviar confirmación del email
    public function enviarConfirmacion(){
        $resend = Resend::client('re_6KS4kMbX_LfeAbyMjJqikQcsW3VJ5HS4k');
        
        $resend->emails->send([
            'from' => 'onboarding@resend.dev',
            'to' => 'larabelcentroestetica@gmail.com',
            'subject' => 'Confirma tu cuenta',
            'html' => "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en LaraBel Centro de Estética, solo debes confirmarla presionando el siguiente enlace</p>".
                    "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>".
                    "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>"
        ]);
    }

    // Enviar reestablecimiento de contraseña
    public function enviarInstrucciones(){
        $resend = Resend::client('re_6KS4kMbX_LfeAbyMjJqikQcsW3VJ5HS4k');
        
        $resend->emails->send([
            'from' => 'onboarding@resend.dev',
            'to' => 'larabelcentroestetica@gmail.com',
            'subject' => 'Reestablece tu contraseña',
            'html' => "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestablecer tu contraseña, sigue el siguiente enlace para hacerlo.</p>".
                    "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Reestablecer Contraseña</a></p>".
                    "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>"
        ]);
    }
}