<?php
namespace Controller;

use Cool\BaseController;
use Model\ArticleManager;
use Model\FormManager;
use Model\MailManager;
use Model\SecurityManager;
use Model\UserManager;

class MainController extends BaseController
{
    public function homeAction()
    {
        $data = [];
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
                $securityManager = new SecurityManager();
                $securityManager->writeInLogs($_POST['username'], "createAccountAction", "log", "account created .");
                return json_encode(['status' => "ok"]);
            } else {
                return json_encode($response);
            }
        }
    }
    public function historyAction()
    {
        return $this->render('history.html.twig');
    }
    public function passwordForgotenAction()
    {
        if (!empty($_POST["email"])) {
            $mailManager = new MailManager();
            $userManager = new UserManager();
            if ($userManager->isEmailValid($_POST['email']) === true) {
                $data = [
                    'email' => "Cet email n'existe pas sur notre site",
                ];
                return json_encode($data);
            } else {
                $result = $mailManager->sendPasswordMail($_POST['email']);
                $data = [
                    'email' => $result,
                ];
                return json_encode($data);
            }
        }
        return $this->redirectToRoute("home");
    }
    public function changePasswordAction()
    {
        if (!empty($_POST['password'])) {
            $userManager = new UserManager();
            $userManager->changePasswordByEmail($_POST['password'], $_POST['email']);
            $securityManager = new SecurityManager();
            $securityManager->writeInLogs($_POST['email'], "changePasswordAction", "log", "changed password .");
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

            $response = $userManager->checkPassword($_POST['username'], $_POST['password']);
            if ($response === true) {
                return json_encode(["status" => "200"]);
            } else {
                $data = [
                    'error' => $response,
                ];
                return json_encode($data);
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
        return $this->render('actualithe.html.twig', $data);

    }

    public function articleAction()
    {
        $data = [

        ];

        if (empty($_SESSION['username']) === false) {
            $data['username'] = $_SESSION['username'];
        }
        return $this->render('article.html.twig', $data);

    }
}
