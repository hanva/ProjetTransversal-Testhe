<?php

require_once 'Cool/DBManager.php';

class FormManager
{
    public function register($firstname, $lastname, $username, $email, $password, $password_repeat)
    {
        $errors = [];
        $formManager = new FormManager();
        if ($formManager->isValidUsername($username) === false) {
            array_push($errors, "username already taken");
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
            $creation = date('Y-m-d H:i:s');
            $result = $pdo->prepare('INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `username`,`creation`) VALUES (NULL, :firstname, :lastname, :email, :password, :username, :creation)');
            $result->bindParam(':firstname', $firstname);
            $result->bindParam(':lastname', $lastname);
            $result->bindParam(':email', $email);
            $result->bindParam(':password', $password);
            $result->bindParam(':username', $username);
            $result->bindParam(':creation', $creation);
            $result->execute();
            return true;
        }
    }
    public function isValidUsername($username)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT username FROM users");
        $posts = $result->fetchAll(PDO::FETCH_COLUMN, 0);
        foreach ($posts as $value) {
            if ($value === $username) {
                return false;
            }
        }
        return true;
    }
}
