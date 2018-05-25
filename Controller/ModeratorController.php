<?php
namespace Controller;

use Cool\BaseController;
use Model\ArticleManager;
use Model\FilesManager;
use Model\FormManager;
use Model\SecurityManager;
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
            $a = '../';
            if (strpos($file, $a) !== false) {
                $securityManager = new SecurityManager();
                $securityManager->writeInLogs($_SESSION['username'], "addArticleAction", "error", "Tried to pass ../ in file");
                return $this->redirectToRoute('home');
            }
            $filesManager->upload($file);
            $userMangager = new UserManager();
            $user_id = $userMangager->getUserId($_SESSION['username']);
            $formMangager = new FormManager();
            $formMangager->addArticle($user_id, $_POST['title'], $file, $_POST['content'], 0);
            $securityManager = new SecurityManager();
            $securityManager->writeInLogs($_SESSION['username'], "addArticleAction", "log", "Created an article");
            return $this->redirectToRoute('home');
        }
        $data = [
            'username' => $_SESSION['username'],
        ];
        return $this->render('addArticle.html.twig', $data);
    }
    public function modifyArticleAction()
    {
        if (!empty($_POST['content'])) {
            if (!empty($_FILES)) {
                $file = $_FILES['picture']['name'];
                $filesManager = new FilesManager();
                $filesManager->upload($file);
            } else {
                $files = '';
            }
            $formMangager = new ArticleManager();
            $formMangager->modifyArticle($_POST['article_id'], $_POST['title'], $file, $_POST['content']);
            $securityManager = new SecurityManager();
            $securityManager->writeInLogs($_SESSION['username'], "modifyArticleAction", "log", "modified an article");
            return $this->redirectToRoute('home');
        } else if (!empty($_SESSION['username']) === false) {
            return $this->redirectToRoute('home');
        } else if (!empty($_GET['article']) && intval($_GET['article'])) {
            $securityManager = new SecurityManager();
            if ($securityManager->getUserStatus($_SESSION['username']) < 2) {
                $userManager = new UserManager();
                $userId = $userManager->getUserId($_SESSION['username']);
                if ($securityManager->checkArticle($_GET['article'], $userId) === false) {
                    $securityManager->writeInLogs($_SESSION['username'], "modifyArticleAction", "error", "Tried to modify other articles");
                    return $this->redirectToRoute('home');
                }
            }
            $articleMangager = new ArticleManager();
            $result = $articleMangager->getArticleById($_GET['article']);
            $data = [
                'article_id' => $_GET['article'],
                'username' => $_SESSION['username'],
                'posts' => $result,
            ];
            return $this->render('modifyArticle.html.twig', $data);
        } else {
            return $this->redirectToRoute('home');
        }
    }
}
