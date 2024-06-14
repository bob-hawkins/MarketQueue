<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Mail {
    protected $mail;
    protected $error;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        //Server settings
        // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = SMTP_USER;
        $this->mail->Password   = SMTP_PASS;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port       = 465;                                    
    
        //Sender
        $this->mail->setFrom(SMTP_USER, 'Market Queue');
        
    }

    public function sendMail($subject, $to, $html){
        try {
            // Recepient
            $this->mail->addAddress($to);

            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $html;
            //$this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; 
            
            $this->mail->send();
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            echo "Message could not be sent." . $this->error;
        }
    }
}

