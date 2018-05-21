<?php
namespace Controller;

use Cool\BaseController;
use Model\ArticleManager;
use Model\FilesManager;
use Model\FormManager;
use Model\UserManager;

class ModeratorController extends BaseController
{
    public function addArticleAction()
    {
        if (!empty($_SESSION['username']) === false) {
            return $this->redirectToRoute('home');
        }
        if (!empty($_FILES)) {
            $file = $_FILES['picture']['name'];
            $filesManager = new FilesManager();
            $filesManager->upload($file);
            $userMangager = new UserManager();
            $user_id = $userMangager->getUserId($_SESSION['username']);
            $formMangager = new FormManager();
            $formMangager->addArticle($user_id, $_POST['title'], $_POST['select'], $file, $_POST['content']);
            return $this->redirectToRoute('home');
        }
        $data = [
            'username' => $_SESSION['username'],
        ];
        return $this->render('addArticle.html.twig', $data);
    }
    public function modifyArticleAction()
    {
        if (!empty($_SESSION['username']) === false) {
            return $this->redirectToRoute('home');
        } else if (!empty($_POST['btn']) && intval($_POST['btn'])) {
            $articleMangager = new ArticleManager();
            $result = $articleMangager->getArticleById($_POST['btn']);

        }
        $data = [
            'username' => $_SESSION['username'],
            'posts' => $result,
        ];

        return $this->render('modifyArticle.html.twig', $data);
    }
}
