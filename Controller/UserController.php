<?php
namespace Controller;

use Cool\BaseController;
use Model\ArticleManager;
use Model\UserManager;

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
    public function profileAction()
    {
        if (empty($_SESSION['username'])) {
            return $this->redirectToRoute('home');
        } else {
            $userManager = new UserManager();
            $user = $userManager->getUserInfos($_SESSION['username']);
            $data = [
                'user' => $user,
            ];
            return $this->render('profile.html.twig', $data);
        }

    }
}
