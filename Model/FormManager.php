<?php

namespace Model;

use Cool\DBManager;
use Model\FormManager;
use PDO;

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
            $userManager = new UserManager();
            $userManager->sendEmail($email, $username);
            return true;
        }
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
