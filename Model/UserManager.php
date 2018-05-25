<?php

namespace Model;

use Cool\DBManager;
use PDO;

class UserManager
{
    public function getUserId($username)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT id from users WHERE username = '$username'");
        $result = $result->fetch(PDO::FETCH_COLUMN, 0);
        return $result;
    }
    public function getUserInfos($username)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT firstname,lastname,birthday,email,description,username from users WHERE username = '$username'");
        $result = $result->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function disconnect()
    {
        session_destroy();
    }
    public function isUsernameValid($username)
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
    public function isEmailValid($email)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT email FROM users");
        $posts = $result->fetchAll(PDO::FETCH_COLUMN, 0);
        foreach ($posts as $value) {
            if ($value === $email) {
                return false;
            }
        }
        return true;
    }
    public function changePasswordByEmail($password, $email)
    {
        $dbm = DBManager::getInstance();
        $cp = sha1($password);
        $pdo = $dbm->getPdo();
        $stmt = $pdo->prepare("UPDATE users SET password=:password WHERE email = :email");
        $stmt->bindParam(':password', $cp);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }
    public function changePasswordByUsername($password)
    {
        $username = $_SESSION['username'];
        $dbm = DBManager::getInstance();
        $cp = sha1($password);
        $pdo = $dbm->getPdo();
        $stmt = $pdo->prepare("UPDATE users SET password=:password WHERE username = :username");
        $stmt->bindParam(':password', $cp);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    }
    public function checkPassword($username, $password)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT password FROM users WHERE username = '$username'");
        $valid = $pdo->query("SELECT valid FROM users WHERE username = '$username'");
        $valid = $valid->fetch(PDO::FETCH_COLUMN, 0);
        $mdp = $result->fetch(PDO::FETCH_COLUMN, 0);
        if ($mdp === sha1($password)) {
            if ($valid !== "1") {
                return "Vous devez d'abord valider votre email pour vous connecter";
            }
            $_SESSION['username'] = $username;
            return true;
        } else {
            return 'Utilisateur ou mot de passe incorect';
        }
    }
    public function editProfile($lastname, $username, $firstname, $email, $birthday, $description)
    {
        $userId = self::getUserId($_SESSION['username']);
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $stmt = $pdo->prepare("UPDATE users SET lastname=:lastname, username=:username, firstname=:firstname, email=:email, birthday=:birthday,description=:description WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':birthday', $birthday);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
        $_SESSION['username'] = $username;
    }
}
