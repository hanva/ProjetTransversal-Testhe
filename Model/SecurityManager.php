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
        $currentkey = '';
        $result = $pdo->query("SELECT valid,moderator,superadmin from users WHERE username = '$username'");
        $result = $result->fetch(PDO::FETCH_ASSOC);
        foreach ($result as $key => $status) {
            if ($status === "0") {
                return $currentkey;
            } else {
                $currentkey = $key;
            }
        }
        return "superadmin";
    }
}
