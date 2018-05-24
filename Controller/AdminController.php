<?php
namespace Controller;

use Cool\BaseController;
use Model\ArticleManager;
use Model\BackOfficeManager;

class AdminController extends BaseController
{
    public function boAction()
    {
        $boManager = new BackOfficeManager();
        $articleManager = new ArticleManager();
        if (!empty($_GET['article'])) {
            $comments = $articleManager->seeCommentsByArticleId(($_GET['article']));
            $commentskeys = $articleManager->seeCommentsKeys();
            $data = [
                'seeComments' => true,
                'comments' => $comments,
                'commentskeys' => $commentskeys,
            ];
            var_dump($data);
            return $this->render('bo.html.twig', $data);
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
            ];
        }
        return $this->render('bo.html.twig', $data);
    }
    public function modifyDataBaseAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id'])) {
            $id = $_GET['id'];
            $BackOfficeManager = new BackOfficeManager();
            $BackOfficeManager->modifyDataBase($id, $_POST['content']);
        }
        return json_encode(['status' => "ok"]);
    }
    public function modifyAllArticlesAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id'])) {
            $id = $_GET['id'];
            $BackOfficeManager = new BackOfficeManager();
            var_dump($_POST['content']);
            $BackOfficeManager->modifyAllArticles($id, $_POST['content']);
        }
        return json_encode(['status' => "ok"]);
    }
    public function modifyCommentsAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id'])) {
            $id = $_GET['id'];
            $BackOfficeManager = new BackOfficeManager();
            var_dump($_POST['content']);
            $BackOfficeManager->modifyComment($id, $_POST['content']);
        }
        return json_encode(['status' => "ok"]);
    }
    public function deleteUserAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id'])) {
            $id = $_GET['id'];
            $BackOfficeManager = new BackOfficeManager();
            $BackOfficeManager->deleteUser($id);
        }
        return json_encode(['status' => "ok"]);
    }
    public function deleteArticleAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id'])) {
            $id = $_GET['id'];
            $BackOfficeManager = new BackOfficeManager();
            $BackOfficeManager->deleteArticle($id);
        }
        return json_encode(['status' => "ok"]);
    }
    public function deleteCommentAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id'])) {
            $id = $_GET['id'];
            $BackOfficeManager = new BackOfficeManager();
            $BackOfficeManager->deleteComment($id);
        }
        return json_encode(['status' => "ok"]);
    }
}
