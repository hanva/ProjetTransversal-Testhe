<?php

namespace Model;

use Cool\DBManager;
use Model\FormManager;

class FormManager
{
    public function register($username, $email, $password)
    {
        $userManager = new UserManager();
        $errors = [];
        if ($userManager->isUsernameValid($username) === false) {
            array_push($errors, "username already taken");
        }
        if ($userManager->isEmailValid($email) === false) {
            array_push($errors, "email already taken");
        }
        if (strlen($username) < 4) {
            array_push($errors, "4 letters needed for an username");
        }
        if (strlen($password) < 6) {
            array_push($errors, "Password too short(min6)");
        }
        if ($errors !== []) {
            return $errors;
        } else {
            $dbm = DBManager::getInstance();
            $pdo = $dbm->getPdo();
            $encryptedpassword = sha1($password);
            $cle = null;
            $valid = 0;
            $creation = date('Y-m-d H:i:s');
            $result = $pdo->prepare("INSERT INTO `users` (`id`, `firstname`, `lastname`, `birthday`, `email`, `description`, `password`, `username`,`creation`,`cle`,`valid`,`moderator`,`superadmin`) VALUES (NULL, '', '','', :email,'', :password, :username, :creation, :cle,:valid, :moderator,:superadmin)");
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
            if ($userManager->sendEmail($email, $username) === true) {
                return true;
            } else {
                array_push($errors, "error while sending the mail");
                return $errors;
            }
        }
    }
    public function addArticle($userid, $title, $pic, $content, $recette)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $creation = date('Y-m-d H:i:s');
        $result = $pdo->prepare('INSERT INTO `articles` (`id`, `user_id`, `title`, `pic`, `content`,`creation`,`is_recette`) VALUES (NULL, :user_id, :title, :pic, :content, :creation ,:is_recette)');
        $result->bindParam(':user_id', $userid);
        $result->bindParam(':title', $title);
        $result->bindParam(':pic', $pic);
        $result->bindParam(':content', $content);
        $result->bindParam(':creation', $creation);
        $result->bindParam(':is_recette', $recette);
        $result->execute();
    }
    public function writeComment($content, $articleId, $username)
    {
        $userManger = new UserManager();
        $userId = $userManager->getUserId($username);
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $creation = date('Y-m-d H:i:s');

        $result = $pdo->prepare('INSERT INTO `comments` (`id`, `user_id`, `article_id`,`content`) VALUES (NULL, :user_id, :user_id, :article_id, :content, :creation)');
        $result->bindParam(':user_id', $userId);
        $result->bindParam(':article_id', $articleId);
        $result->bindParam(':content', $content);
        $result->bindParam(':creation', $creation);
        $result->execute();
    }
}
