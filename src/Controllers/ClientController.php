<?php

namespace App\Controllers;

use App\Models\Client;
use App\Core\DataBase;

class ClientController
{

    public function getClientId($id)
    {
        // var_dump($_SERVER['REQUEST_METHOD']);
        $clientModel = new Client(new DataBase);
        $resultData = $clientModel->getClientById($id);
        echo json_encode(array($resultData));
        //Implementar una funcion sendOutput para enviar la informacion por JSON
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
