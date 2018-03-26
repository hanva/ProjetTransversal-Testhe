<?php

require_once 'Cool/BaseController.php';
require_once 'Model/FormManager.php';

class MainController extends BaseController
{
    public function homeAction()
    {
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
                return $this->redirectToRoute("login");
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
        return $this->render(' login.html.twig');
    }
}
