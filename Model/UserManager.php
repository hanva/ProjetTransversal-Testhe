<?php

namespace Model;

use Cool\DBManager;
use PDO;
use PHPMailer\PHPMailer\PHPMailer;

class UserManager
{

    public function disconnect()
    {
        session_destroy();
    }
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
        $mail->Body = 'Bienvenue sur VotreSite,
        Pour activer votre compte, veuillez cliquer sur le lien ci dessous
        ou copier/coller dans votre navigateur internet.

        http://localhost/ProjetTransversal/?action=validEmail&username=' . urlencode($username) . '&key=' . urlencode($cle) . '

        ---------------
        Ceci est un mail automatique, Merci de ne pas y répondre.';
        $mail->addAddress($email);
        $mail->send();
    }
    public function isValid($username, $type)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT $type FROM users");
        $posts = $result->fetchAll(PDO::FETCH_COLUMN, 0);
        foreach ($posts as $value) {
            if ($value === $username) {
                return false;
            }
        }
        return true;
    }
    public function checkPassword($username, $password)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT password FROM users WHERE username = '$username'");
        $valid = $pdo->query("SELECT valid FROM users WHERE username = '$username'");
        $valid = $valid->fetch(PDO::FETCH_COLUMN, 0);
        $mdp = $result->fetch(PDO::FETCH_COLUMN, 0);
        if ($mdp === $password) {
            if ($valid !== "yes") {
                return "Vous devez d'abord valider votre email pour vous connecter";
            }
            $_SESSION['username'] = $username;
            return true;
        } else {
            return 'Utilisateur ou mot de passe incorect';
        }
    }
}
