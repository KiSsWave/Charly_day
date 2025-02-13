<?php

namespace charly\application\action;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

class SendMailAction extends AbstractAction {

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface {
        $mail = new PHPMailer(true);
        $response = new Response();
        $data = $rq->getParsedBody();

        // Vérification des entrées utilisateur
        $email = $data['email'] ?? null;
        $subject = $data['subject'] ?? 'Aucun sujet';
        $message = $data['message'] ?? 'Message vide';

        if (!$email) {
            $error = ['success' => false, 'error' => 'L\'adresse email est requise.'];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        try {
            // Configuration du serveur SMTP
            $mail->isSMTP();
            $mail->Host       = getenv('SMTP_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = getenv('SMTP_USER');
            $mail->Password   = getenv('SMTP_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Destinataire
            $mail->setFrom('chupachups@alwaysdata.net', 'Charly');
            $mail->addAddress($email);

            // Protection contre XSS
            $cleanMessage = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

            // Contenu du mail
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = nl2br($cleanMessage);

            // Envoyer
            $mail->send();

            $data = [
                'success' => true,
                'message' => 'Message envoyé avec succès'
            ];
            $status = 200;
        } catch (Exception $e) {
            $errorMessage = 'Erreur d\'envoi : ' . $mail->ErrorInfo;
            error_log($errorMessage);
            $data = ['success' => false, 'error' => $errorMessage];
            $status = 500;
        }

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
