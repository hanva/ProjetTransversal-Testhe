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
        try {
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
        <a href="http://localhost/ProjetTransversal/?action=validEmail&username=' . urlencode($username) . '&key=' . urlencode($cle) . '">Cliquez ici !</a>
        ---------------
        Ceci est un mail automatique, Merci de ne pas y répondre.';
            $mail->addAddress($email);
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function sendPasswordMail($email)
    {

        $mail = new PHPMailer();
        try {
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
            $mail->Subject = "Changez de mot de passe";
            $mail->Body = 'Bonjour,
            Cliquez sur le lien pour modifier votre mot de passe
            <a href="http://localhost/ProjetTransversal/?action=changePassword&email=' . urlencode($email) . '">Cliquez ici !</a>


        ---------------
        Ceci est un mail automatique, Merci de ne pas y répondre.';
            $mail->addAddress($email);
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }

    }
    public function validEmail($username, $key)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT cle FROM users WHERE username = '$username'");
        $result = $result->fetch(PDO::FETCH_COLUMN, 0);
        if ($key === $result) {
            $valid = 1;
            $stmt = $pdo->prepare("UPDATE users SET valid=:valid WHERE username = :username");
            $stmt->bindParam(':valid', $valid);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
        }
    }
}
