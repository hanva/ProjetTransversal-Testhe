<?php

namespace Model;

use Cool\DBManager;
use PDO;

class ArticleManager
{
    public function seeAllArticles()
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT * FROM articles  ORDER BY id DESC");
        $posts = $result->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
    public function seeArticleKeys()
    {
        $data = [];
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("select column_name from information_schema.columns where table_name = 'articles' AND TABLE_SCHEMA='testhe'");
        $posts = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach ($posts as $value) {
            foreach ($value as $key) {
                array_push($data, $key);
            }
        }
        return $data;
    }
    public function getArticleById($id)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT * FROM articles WHERE id = $id");   
        $posts = $result->fetch(PDO::FETCH_ASSOC); 
        return $posts;
    }
}
