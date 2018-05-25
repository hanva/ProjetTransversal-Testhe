<?php
namespace Controller;

use Cool\BaseController;
use Model\ArticleManager;
use Model\BackOfficeManager;
use Model\SecurityManager;
use Model\UserManager;

class AdminController extends BaseController
{
    public function boAction()
    {
        $securityManager = new SecurityManager();
        if (empty($_SESSION['username']) || $securityManager->getUserStatus($_SESSION['username']) < 3) {
            $securityManager = new SecurityManager();
            $securityManager->writeInLogs($_SESSION['username'], "boAction", "error", "Tried to acces to the back-office " . $id);
            return $this->redirectToRoute('home');
        }
        $boManager = new BackOfficeManager();
        $articleManager = new ArticleManager();
        if (!empty($_GET['article'])) {
            $comments = $articleManager->seeCommentsByArticleId(($_GET['article']));
            $commentskeys = $articleManager->seeCommentsKeys();
            $data = [
                'seeComments' => true,
                'comments' => $comments,
                'commentskeys' => $commentskeys,
                'logs' => false,
            ];
            return $this->render('bo.html.twig', $data);
        } elseif (!empty($_GET['log'])) {
            $logs = $boManager->getLogs();
            $logskeys = $boManager->getLogskeys();
            $data = [
                'logs' => $logs,
                'logskeys' => $logskeys,
            ];
            return $this->render('logs.html.twig', $data);
        } else {
            $infos = $boManager->getUsersInfos();
            $keyinfos = $boManager->getUsersKeys();
            $articles = $articleManager->seeAllArticles();
            $articlekeys = $articleManager->seeArticleKeys();
            $data = [
                'seeComments' => false,
                'infos' => $infos,
                'userkeys' => $keyinfos,
                'articles' => $articles,
                'articlekeys' => $articlekeys,
                'logs' => false,
            ];
        }
        return $this->render('bo.html.twig', $data);
    }
    public function modifyUserAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id'])) {
            $id = $_GET['id'];
            $BackOfficeManager = new BackOfficeManager();
            $BackOfficeManager->modifyUser($id, $_POST['content']);
            $securityManager = new SecurityManager();
            $securityManager->writeInLogs($_SESSION['username'], "modifyDataBaseAction", "log", "Modified  user : " . $id);
        }
        return json_encode(['status' => "ok"]);
    }
    public function modifyAllArticlesAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id'])) {
            $id = $_GET['id'];
            $BackOfficeManager = new BackOfficeManager();
            $BackOfficeManager->modifyAllArticles($id, $_POST['content']);
        }
        return json_encode(['status' => "ok"]);
    }
    public function modifyCommentsAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id'])) {
            $id = $_GET['id'];
            $BackOfficeManager = new BackOfficeManager();
            $BackOfficeManager->modifyComment($id, $_POST['content']);
            $securityManager = new SecurityManager();
            $securityManager->writeInLogs($_SESSION['username'], "modifyCommentsAction", "log", "Modified  comment : " . $id);
        }
        return json_encode(['status' => "ok"]);
    }
    public function deleteUserAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id'])) {
            $id = $_GET['id'];
            $BackOfficeManager = new BackOfficeManager();
            $BackOfficeManager->deleteUser($id);
            $securityManager = new SecurityManager();
            $securityManager->writeInLogs($_SESSION['username'], "deleteUserAction", "log", "Deleted  user : " . $id);
        }
        return json_encode(['status' => "ok"]);
    }
    public function deleteArticleAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id'])) {
            $securityManager = new SecurityManager();
            if ($securityManager->getUserStatus($_SESSION['username']) < 2) {
                $userManager = new UserManager();
                $userId = $userManager->getUserId($_SESSION['username']);
                if ($securityManager->checkArticle($_GET['id'], $userId) === false) {
                    $securityManager->writeInLogs($_SESSION['username'], "deleteArticleAction", "error", "Tried to delete other articles");
                    return json_encode(['status' => "error"]);
                }
            }
            $BackOfficeManager = new BackOfficeManager();
            $BackOfficeManager->deleteArticle($id);
            $securityManager->writeInLogs($_SESSION['username'], "deleteArticleAction", "log", "Deleted  article : " . $id);
        }
        return json_encode(['status' => "ok"]);
    }
    public function deleteCommentAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id'])) {
            $id = $_GET['id'];
            $BackOfficeManager = new BackOfficeManager();
            $BackOfficeManager->deleteComment($id);
            $securityManager = new SecurityManager();
            $securityManager->writeInLogs($_SESSION['username'], "deleteCommentAction", "log", "Deleted  comment : " . $id);
        }
        return json_encode(['status' => "ok"]);
    }
}
