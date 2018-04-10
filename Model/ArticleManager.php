<?php

namespace Model;

use Cool\DBManager;

class ArticleManager
{
    public function seeAllArticles()
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT * FROM articles  ORDER BY id DESC");
        $posts = $result->fetch();
        echo ("<pre>");
        var_dump($posts);
        die;
        return $posts;
    }
}
