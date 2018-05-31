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
            $errors['username'] = "ce nom de compte est déjà utilisé";
        }
        if ($userManager->isEmailValid($email) === false) {
            $errors['email'] = "Cet Email est déjà utilisé !";
        }
        if (strlen($username) < 4) {
            $errors['username'] = "le mot de compte est trop court ! (minimum 4)";
        }
        if (strlen($password) < 6) {
            $errors['password'] = "le mot de passe est trop court ! (minimum 6)";
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
    public function addArticle($userid, $title, $pic, $content, $recette, $recetteIngredients, $tag)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $creation = date('Y-m-d H:i:s');
        $likes = 0;
        $result = $pdo->prepare('INSERT INTO `articles` (`id`, `title` , `user_id`, `pic`, `content`,`creation`,`is_recette`,`recette_ingredients`,`likes`) VALUES (NULL, :title ,:user_id, :pic, :content, :creation ,:is_recette,:recette_ingredients,:likes)');
        $result->bindParam(':user_id', $userid);
        $result->bindParam(':title', $title);
        $result->bindParam(':pic', $pic);
        $result->bindParam(':content', $content);
        $result->bindParam(':creation', $creation);
        $result->bindParam(':is_recette', $recette);
        $result->bindParam(':recette_ingredients', $recetteIngredients);
        $result->bindParam(':likes', $likes);
        $result->execute();
        $articleId = $pdo->lastInsertId();
        if ($recette === "1") {
            $articleId = intval($articleId);
            self::addTagToArticle($tag, $articleId);
        }
    }
    public function addTagToArticle($tag, $id)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        if ($tag === "Plats cuisinés" or $tag === "Légumes" or $tag === "Tartes salées") {
            $rubrique = "Plats";
        } else if ($tag === "Biscuits" or $tag === "Gateaux" or $tag === "Tartes sucrées") {
            $rubrique = "Dessert";
        } else {
            $rubrique = "Instant thé";
        }
        $result = $pdo->prepare('INSERT INTO `rubriques` (`id`, `article_id`, `rubrique`, `tag`) VALUES (NULL, :article_id, :rubrique, :tag)');
        $result->bindParam(':article_id', $id);
        $result->bindParam(':rubrique', $rubrique);
        $result->bindParam(':tag', $tag);
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
