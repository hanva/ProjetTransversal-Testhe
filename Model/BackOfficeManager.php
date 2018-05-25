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

    public function getLogs()
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT * FROM operations  ORDER BY id DESC");
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
    public function getLogsKeys()
    {
        $data = [];
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("select column_name from information_schema.columns where  table_name = 'operations' AND TABLE_SCHEMA='testhe'");
        $posts = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach ($posts as $value) {
            foreach ($value as $key) {
                array_push($data, $key);
            }
        }
        return $data;
    }
    public function modifyUser($id, $content)
    {

        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $array = (json_decode($content));
        foreach ($array as $key => $value) {
            $stmt = $pdo->prepare("UPDATE users SET $key= '$value' WHERE id = $id");
            $stmt->execute();
        }
    }
    public function modifyAllArticles($id, $content)
    {

        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $array = (json_decode($content));
        foreach ($array as $key => $value) {
            $stmt = $pdo->prepare("UPDATE articles SET $key= '$value' WHERE id = $id");
            $stmt->execute();
        }
    }
    public function modifyComment($id, $content)
    {

        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $array = (json_decode($content));
        var_dump($array);
        foreach ($array as $key => $value) {
            $stmt = $pdo->prepare("UPDATE comments SET $key= '$value' WHERE id = $id");
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
        $stmt = $pdo->prepare("DELETE from comments WHERE article_id = $id");
        $stmt->execute();
    }
    public function deleteComment($id)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $stmt = $pdo->prepare("DELETE from comments WHERE id = $id");
        $stmt->execute();
    }
}
