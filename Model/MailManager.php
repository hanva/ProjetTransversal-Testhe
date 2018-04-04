<?php

namespace Model;

use Cool\DBManager;
use PDO;
use PHPMailer\PHPMailer\PHPMailer;

class MailManager
{
    public function sendEmail($email, $username)
    {
        $cle = md5(microtime(true) * 100000);
        $isValid = "no";
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $stmt = $pdo->prepare("UPDATE users SET cle=:cle WHERE username = :username");
        $stmt->bindParam(':cle', $cle);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '465';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ),
        );
        $mail->isHTML();
        $mail->Username = "testhepourtous@gmail.com";
        $mail->Password = "lethecestbon";
        $mail->setFrom('no-replys@gmail.fr');
        $mail->Subject = "Activer votre compte";
        $mail->Body = 'Bienvenue sur Thesthe,
        Pour activer votre compte, veuillez cliquer sur le lien ci dessous
        ou copier/coller dans votre navigateur internet.

        http://localhost/ProjetTransversal/?action=validEmail&username=' . urlencode($username) . '&key=' . urlencode($cle) . '

        ---------------
        Ceci est un mail automatique, Merci de ne pas y répondre.';
        $mail->addAddress($email);
        $mail->send();
    }
    public function validEmail($username, $key)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT cle FROM users WHERE username = '$username'");
        $result = $result->fetch(PDO::FETCH_COLUMN, 0);
        if ($key === $result) {
            $valid = "yes";
            $stmt = $pdo->prepare("UPDATE users SET valid=:valid WHERE username = :username");
            $stmt->bindParam(':valid', $valid);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
        }
    }
}
