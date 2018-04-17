<?php
namespace Controller;

use Cool\BaseController;
use Model\BackOfficeManager;

class AdminController extends BaseController
{
    public function boAction()
    {
        $boManager = new BackOfficeManager();
        $infos = $boManager->getUsersInfos();
        $keyinfos = $boManager->getUsersKeys();
        $data = [
            'infos' => $infos,
            'userkeys' => $keyinfos,
        ];
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
    public function deleteUserAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id'])) {
            $id = $_GET['id'];
            $BackOfficeManager = new BackOfficeManager();
            $BackOfficeManager->deleteUser($id);
        }
        return json_encode(['status' => "ok"]);
    }
}
