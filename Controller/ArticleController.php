<?php
namespace Controller;

use Cool\BaseController;

session_start();

class ArticleController extends BaseController
{
    public function addArticleAction()
    {
        if (empty($_SESSION['username']) === false) {
            $data = [
                'username' => $_SESSION['username'],
            ];
            return $this->render('addArticle.html.twig', $data);
        }
        return $this->render('addArticle.html.twig');
    }
}
