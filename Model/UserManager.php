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
    public function isEmailValid($username)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT email FROM users");
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
        if ($mdp === sha1($password)) {
            if ($valid !== 1) {
                return "Vous devez d'abord valider votre email pour vous connecter";
            }
            $_SESSION['username'] = $username;
            return true;
        } else {
            return 'Utilisateur ou mot de passe incorect';
        }
    }
}
