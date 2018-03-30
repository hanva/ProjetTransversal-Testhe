<?php
namespace Controller;

use Cool\BaseController;
use Model\FormManager;
use Model\UserManager;

session_start();

class MainController extends BaseController
{
    public function homeAction()
    {
        if (empty($_SESSION['username']) === false) {
            $data = [
                'username' => $_SESSION['username'],
            ];
            return $this->render('home.html.twig', $data);
        }
        return $this->render('home.html.twig');
    }
    public function createAccountAction()
    {
        if (!empty($_POST['firstname']) && !empty($_POST['lastname'])
            && !empty($_POST['username']) && !empty($_POST['email'])
            && !empty($_POST['password']) && !empty($_POST['password_repeat'])) {
            $formManager = new FormManager();
            $response = $formManager->register($_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['password_repeat']);
            if ($response === true) {
                return $this->redirectToRoute("validated");
            } else {
                $data = [
                    'errors' => $response,
                ];
                return $this->render('createAccount.html.twig', $data);
            }
        } else {
            return $this->render('createAccount.html.twig');
        }
    }

    public function loginAction()
    {
        $userManager = new UserManager();
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            if ($response = $userManager->isValid($_POST['username'], 'username') === false) {
                $response = $userManager->checkPassword($_POST['username'], $_POST['password']);
                if ($response === true) {
                    return $this->redirectToRoute("home");
                } else {
                    $data = [
                        'error' => $response,
                    ];
                    return $this->render('login.html.twig', $data);
                }
            }
            $data = [
                'error' => 'Utilisateur ou mot de passe incorect',
            ];
            return $this->render('login.html.twig', $data);
        }
        return $this->render('login.html.twig');
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
            $formManager = new FormManager();
            $formManager->validEmail($_GET['username'], ($_GET['key']));
            return $this->redirectToRoute('login');
        } else {
            return $this->redirectToRoute('home');
        }
    }
}
