<?php
namespace Controller;

use Cool\BaseController;
use Model\FormManager;

session_start();

class ModeratorController extends BaseController
{
    public function addArticleAction()
    {
        if (!empty($_SESSION['username']) === false) {
            return $this->redirectToRoute('home');
        }
        if (!empty($_FILES)) {
            $file = $_FILES['picture']['name'];
            $formMangager = new FormManager();
            $formMangager->addArticle($_SESSION['username'], $_POST['title'], $_POST['select'], $file, $_POST['content']);
            return $this->redirectToRoute('home');
        }
        $data = [
            'username' => $_SESSION['username'],
        ];
        return $this->render('addArticle.html.twig', $data);
    }
}
