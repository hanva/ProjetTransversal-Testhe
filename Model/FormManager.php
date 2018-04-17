<?php

namespace Model;

use Cool\DBManager;
use Model\FormManager;

class FormManager
{
    public function register($firstname, $lastname, $username, $email, $password, $password_repeat)
    {
        $userManager = new UserManager();
        $errors = [];
        if ($userManager->isValid($username, 'username') === false) {
            array_push($errors, "username already taken");
        }
        if ($userManager->isValid($email, 'email') === false) {
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
            $encryptedpassword = sha1($password);
            $cle = null;
            $valid = "no";
            $creation = date('Y-m-d H:i:s');
            $result = $pdo->prepare('INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `username`,`creation`,`cle`,`valid`,`moderator`,`superadmin`) VALUES (NULL, :firstname, :lastname, :email, :password, :username, :creation, :cle,:valid, :moderator,:superadmin)');
            $result->bindParam(':firstname', $firstname);
            $result->bindParam(':lastname', $lastname);
            $result->bindParam(':email', $email);
            $result->bindParam(':password', $encryptedpassword);
            $result->bindParam(':username', $username);
            $result->bindParam(':creation', $creation);
            $result->bindParam(':cle', $cle);
            $result->bindParam(':valid', $valid);
            $result->bindParam(':moderator', $valid);
            $result->bindParam(':superadmin', $valid);
            $result->execute();
            $userManager = new MailManager();
            $userManager->sendEmail($email, $username);
            return true;
        }
    }
    public function addArticle($userid, $title, $tag, $pic, $content)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $creation = date('Y-m-d H:i:s');
        $result = $pdo->prepare('INSERT INTO `articles` (`id`, `user_id`, `title`, `tag`, `pic`, `content`,`creation`) VALUES (NULL, :user_id, :title, :tag, :pic, :content, :creation)');
        $result->bindParam(':user_id', $userid);
        $result->bindParam(':title', $title);
        $result->bindParam(':tag', $tag);
        $result->bindParam(':pic', $pic);
        $result->bindParam(':content', $content);
        $result->bindParam(':creation', $creation);
        $result->execute();
    }
}
