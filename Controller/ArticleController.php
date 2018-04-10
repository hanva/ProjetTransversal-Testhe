<?php
namespace Controller;

use Cool\BaseController;

session_start();

class ArticleController extends BaseController
{
    public function addArticleAction()
    {
        if (empty($_SESSION['username']) === false) {
            if (empty($_POST['select']) === false) {
                die;
            }
            $data = [
                'username' => $_SESSION['username'],
            ];
            return $this->render('addArticle.html.twig', $data);
        }
        return $this->render('home.html.twig');
    }
}
