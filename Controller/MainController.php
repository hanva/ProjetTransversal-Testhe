<?php
namespace Controller;

use Cool\BaseController;
use Model\ArticleManager;
use Model\FormManager;
use Model\MailManager;
use Model\UserManager;

class MainController extends BaseController
{
    public function homeAction()
    {
        $articleManager = new ArticleManager();
        $articles = $articleManager->seeAllArticles();
        $articlekeys = $articleManager->seeArticleKeys();
        $data = [
            'articles' => $articles,
            'articlekeys' => $articlekeys,
        ];
        if (empty($_SESSION['username']) === false) {
            $data['username'] = $_SESSION['username'];
        }
        return $this->render('home.html.twig', $data);

    }
    public function createAccountAction()
    {
        if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {
            $formManager = new FormManager();
            $response = $formManager->register($_POST['username'], $_POST['email'], $_POST['password']);
            if ($response === true) {
                return json_encode(['status' => "ok"]);
            } else {
                return json_encode(['status' => $response]);
            }
        }
    }
    public function historyAction()
    {
        return $this->render('history.html.twig');

    }
    public function passwordForgotenAction()
    {
        if (!empty($_POST["Email"])) {
            var_dump($_POST["Email"]);
            $mailManager = new MailManager();
            $result = $mailManager->sendPasswordMail($_POST['Email']);
            var_dump($result);
            $data = [
                'email' => $_POST['Email'],
            ];
            return $this->render("passwordForgoten.html.twig", $data);
        }
    }
    public function changePasswordAction()
    {
        if (!empty($_POST['password'])) {
            $userManager = new UserManager();
            $userManager->changePassword($_POST['password'], $_POST['email']);
            die;
            return $this->redirectToRoute('home');

        } else {
            if (empty($_GET['email'])) {
                return $this->redirectToRoute('home');
            } else {
                $data = [
                    'email' => $_GET['email'],
                ];
                return $this->render("changePassword.html.twig", $data);
            }
        }
    }
    public function loginAction()
    {
        $userManager = new UserManager();
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            if ($response = $userManager->isUsernameValid($_POST['username']) === false) {
                $response = $userManager->checkPassword($_POST['username'], $_POST['password']);
                if ($response === true) {
                    return $this->redirectToRoute("home");
                } else {
                    $data = [
                        'error' => $response,
                    ];
                    return $this->redirectToRoute("home", $response);
                }
            }
        }
        return $this->redirectToRoute("home");
    }
    public function validatedAction()
    {
        return $this->render('validated.html.twig');
    }
    public function disconnectAction()
    {
        if (!empty($_SESSION['username']) === false) {
            return $this->redirectToRoute('home');
        } else {
            $userManager = new UserManager();
            $userManager->disconnect();
            return $this->redirectToRoute('home');
        }
    }
    public function validEmailAction()
    {
        if (!empty($_GET['username']) === true && !empty($_GET['key']) === true) {
            $userManager = new MailManager();
            $userManager->validEmail($_GET['username'], ($_GET['key']));
            return $this->redirectToRoute('home');
        } else {
            return $this->redirectToRoute('home');
        }
    }
    public function actualitheAction()
    {
        $data = [

        ];

        if (empty($_SESSION['username']) === false) {
            $data['username'] = $_SESSION['username'];
        }
        return $this->render('actualithe.html.twig', $data);

    }
}
