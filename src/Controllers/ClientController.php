<?php

namespace App\Controllers;

use App\Models\Client;
use App\Core\DataBase;

class ClientController extends BaseController
{

    public function getClientId($id)
    {
        $clientModel = new Client(new DataBase);
        $resultData = $clientModel->getClientById($id);
        echo json_encode(array($resultData));
    }

    public function getAll()
    {
        $clientModel = new Client(new DataBase);
        $resultData = $clientModel->getAllClients();
        foreach ($resultData as $valueArray) {
            echo json_encode($valueArray) . "\n";
        }
    }
}
