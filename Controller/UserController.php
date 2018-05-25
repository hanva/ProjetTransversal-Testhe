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
            $articleMangager = new ArticleManager();
            $user = $userManager->getUserInfos($_SESSION['username']);
            $userId = $userManager->getUserId($_SESSION['username']);
            $articles = $articleMangager->getArticlesById($userId);
            $comments = $articleMangager->getCommentsById($userId);
            $data = [
                'user' => $user,
                'username' => $_SESSION['username'],
                'articles' => $articles,
                'comments' => $comments,
            ];
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
