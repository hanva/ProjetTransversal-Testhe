<?php
namespace Controller;

use Cool\BaseController;

class UserController extends BaseController
{
    public function writeCommentAction()
    {
        if (empty($_SESSION['username'])) {
            $data = [
                'error' => "Vous devez être connecté pour écrire un commentaire",
            ];
            return $this->redirectToRoute("article", $data);
        }
        $ArticleManager = new ArticleManager();
        $result = $articleMangager->writeComment($_POST['content'], $_POST['article_id'], $_SESSION['username']);
    }
}
