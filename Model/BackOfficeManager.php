<?php

namespace Model;

use Cool\DBManager;
use PDO;

class BackOfficeManager
{
    public function getUsersInfos()
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT * FROM users  ORDER BY id DESC");
        $posts = $result->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
    public function getUsersKeys()
    {
        $data = [];
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("select column_name from information_schema.columns where  table_name = 'users' AND TABLE_SCHEMA='testhe'");
        $posts = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach ($posts as $value) {
            foreach ($value as $key) {
                array_push($data, $key);
            }
        }
        return $data;
    }
    public function modifyDataBase($id, $content)
    {

        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $array = (json_decode($content));
        foreach ($array as $key => $value) {
            $stmt = $pdo->prepare("UPDATE users SET $key= '$value' WHERE id = $id");
            $stmt->execute();
        }
    }
    public function deleteUser($id)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $stmt = $pdo->prepare("DELETE from users WHERE id = $id");
        $stmt->execute();
    }
    public function deleteArticle($id)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $stmt = $pdo->prepare("DELETE from articles WHERE id = $id");
        $stmt->execute();
    }
}
