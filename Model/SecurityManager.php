<?php

namespace Model;

use Cool\DBManager;
use PDO;

class SecurityManager
{
    public function getUserStatus($username)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $currentkey = 0;
        $result = $pdo->query("SELECT valid,moderator,superadmin from users WHERE username = '$username'");
        $result = $result->fetch(PDO::FETCH_ASSOC);
        foreach ($result as $key => $status) {
            if ($status === "0") {
                return $currentkey;
            } else {
                $currentkey = $currentkey + 1;
            }
        }
        return $currentkey;
    }
    public function checkArticle($id, $userId)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT user_id from articles WHERE id = '$id'");
        $result = $result->fetch(PDO::FETCH_COLUMN);
        if ($result === $userId) {
            return true;
        }
        return false;
    }
    public function writeInLogs($username = "unknown", $action, $type, $content)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $creation = date('Y-m-d H:i:s');
        $result = $pdo->prepare("INSERT INTO `operations` (`id`, `user_username`, `action`, `type`, `content`, `creation`) VALUES (NULL, :user_username , :action, :type,:content, :creation)");
        $result->bindParam(':user_username', $username);
        $result->bindParam(':action', $action);
        $result->bindParam(':type', $type);
        $result->bindParam(':content', $content);
        $result->bindParam(':creation', $creation);
        $result->execute();
    }
}
