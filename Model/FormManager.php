<?php

require_once 'Cool/DBManager.php';
require_once 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

class FormManager
{
    public function register($firstname, $lastname, $username, $email, $password, $password_repeat)
    {
        $formManager = new FormManager();
        $errors = [];
        if ($formManager->isValid($username, 'username') === false) {
            array_push($errors, "username already taken");
        }
        if ($formManager->isValid($email, 'email') === false) {
            array_push($errors, "email already taken");
        }
        if (strlen($username) < 4) {
            array_push($errors, "4 letters needed for an username");
        }
        if (strlen($firstname) < 1) {
            array_push($errors, "Enter a first name");
        }
        if (strlen($lastname) < 1) {
            array_push($errors, "Enter a last name");
        }
        if (strlen($password) < 6) {
            array_push($errors, "Password too short(min6)");
        }
        if ($password !== $password_repeat) {
            array_push($errors, "Passwords does not match");
        }
        if ($errors !== []) {
            return $errors;
        } else {
            $dbm = DBManager::getInstance();
            $pdo = $dbm->getPdo();
            $cle = null;
            $valid = "no";
            $creation = date('Y-m-d H:i:s');
            $result = $pdo->prepare('INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `username`,`creation`,`cle`,`valid`) VALUES (NULL, :firstname, :lastname, :email, :password, :username, :creation, :cle,:valid)');
            $result->bindParam(':firstname', $firstname);
            $result->bindParam(':lastname', $lastname);
            $result->bindParam(':email', $email);
            $result->bindParam(':password', $password);
            $result->bindParam(':username', $username);
            $result->bindParam(':creation', $creation);
            $result->bindParam(':cle', $cle);
            $result->bindParam(':valid', $valid);
            $result->execute();
            $formManager->sendEmail($email, $username);
            return true;
        }
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

    public function disconnect()
    {
        session_destroy();
    }
}
