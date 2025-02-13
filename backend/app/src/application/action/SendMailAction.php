<?php

use charly\application\action\AbstractAction;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendMailAction extends AbstractAction {

    public function __invoke(Psr\Http\Message\ServerRequestInterface $rq, Psr\Http\Message\ResponseInterface $rs, array $args): Psr\Http\Message\ResponseInterface {

        $mail = new PHPMailer(true);

        try {
            // Configuration du serveur SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.alwaysdata.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'votre-email@alwaysdata.net'; // Remplacez par votre email
            $mail->Password   = 'votre-mot-de-passe'; // Remplacez par votre mot de passe
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // STARTTLS recommandé
            $mail->Port       = 587;

            // Destinataire
            $mail->setFrom('votre-email@alwaysdata.net', 'Votre Nom');
            $mail->addAddress('destinataire@example.com');

            // Contenu du mail
            $mail->isHTML(true);
            $mail->Subject = 'Test SMTP Alwaysdata';
            $mail->Body    = 'Ceci est un test d\'envoi via le serveur SMTP d\'Alwaysdata.';

            // Envoyer
            $mail->send();
            echo 'Message envoyé avec succès';
        } catch (Exception $e) {
            echo "Erreur : {$mail->ErrorInfo}";
        }

    }
}