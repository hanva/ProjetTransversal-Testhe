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
        $securityManager = new SecurityManager();
        if ($securityManager->getUserStatus($_SESSION['username']) < 2) {
            $userStatus = "user";
        } else {
            $userStatus = "moderator";
        }
        if (!empty($_FILES)) {
            $file = $_FILES['file']['name'];
            $filesManager = new FilesManager();
            $a = '../';
            if (strpos($file, $a) !== false) {
                $securityManager->writeInLogs($_SESSION['username'], "addArticleAction", "error", "Tried to pass ../ in file");
                return \json_encode('error');
            }
            $filesManager->upload($file);
            return \json_encode("200");
        }
        if (!empty($_POST['content'])) {
            $userMangager = new UserManager();
            $user_id = $userMangager->getUserId($_SESSION['username']);
            $formMangager = new FormManager();
            $securityManager = new SecurityManager();
            if (isset($_POST['ingredients'])) {
                $formMangager->addArticle($user_id, $_POST['title'], $_POST['picture'], $_POST['content'], 1, $_POST['ingredients'], $_POST['tag']);
                $securityManager->writeInLogs($_SESSION['username'], "addArticleAction", "log", "Created a Recipe");
            } else {
                $formMangager->addArticle($user_id, $_POST['title'], $_POST['picture'], $_POST['content'], 0, "", "");
                $securityManager->writeInLogs($_SESSION['username'], "addArticleAction", "log", "Created an article");
            }
            return \json_encode('200');
        }
        $data = [
            'username' => $_SESSION['username'],
            'user' => $userStatus,
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
            $data = "modify=1";
            return $this->redirectToRoute('profile', $data);
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
