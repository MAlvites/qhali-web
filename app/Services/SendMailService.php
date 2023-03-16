<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendMailService
{
    protected $appName;
    protected $host;
    protected $username;
    protected $password;
    protected $port;
    protected $encryption;
    protected $emailTo;
    protected $subject;
    protected $body;
    protected $attach;

    public function __construct(string $emailTo, string $subject, $body, string $attach = null)
    {
       $this->appName = config("app.name");
       $this->host = config("mail.mailers.smtp.host");
       $this->username = config("mail.mailers.smtp.username");
       $this->password = config("mail.mailers.smtp.password");
       $this->port = config("mail.mailers.smtp.port");
       $this->encryption = config("mail.mailers.smtp.encryption");
       $this->emailTo = $emailTo;
       $this->subject = $subject;
       $this->body = $body;
       $this->attach = $attach;
    }

    public function __invoke()
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = $this->host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->username;
            $mail->Password   = $this->password;
            $mail->SMTPSecure = $this->encryption;
            $mail->Port       = $this->port;

            //Recipients
            $mail->setFrom($this->username, $this->appName);
            $mail->addAddress($this->emailTo);

            //Attachments
            if ($this->attach) {
                $mail->addAttachment($this->attach); 
            }

            //Content
            $mail->isHTML(true);
            $mail->Subject = $this->subject;
            $mail->Body    = $this->body;

            $mail->send();
        } catch (Exception $e) {
            return "El correo no puede ser enviado. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
