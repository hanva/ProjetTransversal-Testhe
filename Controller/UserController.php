<?php
namespace Controller;

use Cool\BaseController;
use Model\ArticleManager;
use Model\SecurityManager;
use Model\UserManager;

class UserController extends BaseController
{
    public function likeAction()
    {
        $articleMangager = new ArticleManager();
        $userManager = new UserManager();
        $userId = $userManager->getUserId($_SESSION['username']);
        $isLiked = $articleMangager->searchLikeById($userId, $_GET['id']);
        if (isset($_GET['id'])) {
            if ($isLiked === false) {
                $likes = $articleMangager->like($userId, $_GET['id']);
            } else {
                $likes = $articleMangager->unlike($userId, $_GET['id']);
            }
            return json_encode($likes);
        }
        return json_encode($isLiked);
    }
    public function writeCommentAction()
    {
        if (empty($_SESSION['username'])) {
            $data = [
                'error' => "Vous devez être connecté pour écrire un commentaire",
            ];
            return $this->redirectToRoute("article", $data);
        }
        $ArticleManager = new ArticleManager();
        $data = $ArticleManager->commentArticle($_POST['content'], $_POST['id'], $_SESSION['username']);
        $securityManager = new SecurityManager();
        $securityManager->writeInLogs($_SESSION['username'], "writeCommentAction", "log", "New Comment : ");
        return json_encode($data);
    }
    public function profileAction()
    {
        if (empty($_SESSION['username'])) {
            return $this->redirectToRoute('home');
        } else {
            $userManager = new UserManager();
            $articleMangager = new ArticleManager();
            $user = $userManager->getUserInfos($_SESSION['username']);
            $userId = $userManager->getUserId($_SESSION['username']);
            $articles = $articleMangager->getArticlesByUserId($userId);
            $comments = $articleMangager->getCommentsById($userId);
            $data = [
                'user' => $user,
                'username' => $_SESSION['username'],
                'articles' => $articles,
                'comments' => $comments,
            ];
            if (isset($_GET['modify']) && $_GET['modify'] === "1") {
                $data['modify'] = 1;
            }
            return $this->render('profile.html.twig', $data);
        }
    }
    public function modifyPasswordAction()
    {
        if (empty($_SESSION['username'])) {
            return $this->redirectToRoute('home');
        }
        if (!empty($_POST['password'])) {
            $userManager = new UserManager();
            $result = $userManager->checkPassword($_SESSION['username'], $_POST['password']);
            if ($result === true) {
                if ($_POST['newPassword'] === $_POST['passwordRepeat']) {
                    $userManager->changePasswordByUsername($_POST['newPassword']);
                    return $this->redirectToRoute('profil');
                } else {
                    $result = 'mot de passe non identiques';
                }
                $data = [
                    'error' => $result,
                ];
                return $this->render('modifyPassword.html.twig', $data);
            }
        }
        return $this->render('modifyPassword.html.twig');
    }
    public function editProfileAction()
    {
        $lastname = $_POST["lastname"];
        $username = $_POST["username"];
        $firstname = $_POST["firstname"];
        $email = $_POST["email"];
        $birthday = $_POST["birthday"];
        $description = $_POST["description"];
        $userManager = new UserManager();
        $userManager->EditProfile($lastname, $username, $firstname, $email, $birthday, $description);
        return $this->redirectToRoute('profile');
    }
}
