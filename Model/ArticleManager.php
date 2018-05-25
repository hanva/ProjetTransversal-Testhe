<?php

namespace Model;

use Cool\DBManager;
use Model\UserManager;
use PDO;

class ArticleManager
{
    public function seeAllArticles()
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT * FROM articles where is_recette=0   ORDER BY id DESC");
        $posts = $result->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
    public function seeAllRecettes()
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT * FROM articles where is_recette=1  ORDER BY id DESC ");
        $posts = $result->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
    public function getCommentsById($id)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT * FROM comments where user_id=$id  ORDER BY id DESC ");
        $posts = $result->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
    public function seeCommentsByArticleId($id)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT * FROM comments where article_id=$id  ORDER BY id DESC ");
        $posts = $result->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
    public function modifyArticle($articleId, $title, $file, $content)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $stmt = $pdo->prepare("UPDATE articles SET title=:title,content=:content WHERE id =:id");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':id', $articleId);
        $stmt->execute();
        if ($file !== "") {
            $stmt = $pdo->prepare("UPDATE articles SET pic=:pic WHERE id=:id");
            $stmt->bindParam(':pic', $file);
            $stmt->bindParam(':id', $articleId);
            $stmt->execute();
        }
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
    public function seeCommentsKeys()
    {
        $data = [];
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("select column_name from information_schema.columns where table_name = 'comments' AND TABLE_SCHEMA='testhe'");
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
    public function getArticlesByUserId($id)
    {
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->query("SELECT * FROM articles where user_id=$id  ORDER BY id DESC ");
        $posts = $result->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
    public function commentArticle($content, $id, $username)
    {
        $userManager = new UserManager();
        $userId = $userManager->getUserId($username);
        $dbm = DBManager::getInstance();
        $pdo = $dbm->getPdo();
        $result = $pdo->prepare('INSERT INTO `comments` (`id`, `user_id`, `article_id`, `content`,`user_name`) VALUES (NULL, :user_id, :article_id, :content,:user_name)');
        $result->bindParam(':user_id', $userId);
        $result->bindParam(':article_id', $id);
        $result->bindParam(':content', $content);
        $result->bindParam(':user_name', $username);
        $result->execute();
        $data = [
            'username' => $username,
            'content' => $content,
        ];
        return $data;
    }
}
