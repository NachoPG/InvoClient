<?php

namespace App\Controllers;

use App\Models\Client;
use App\Core\DataBase;
use Error;

class ClientController extends BaseController
{


    public function getClientId($id)
    {
        $clientModel = new Client(new DataBase);
        $resultData = $clientModel->getClientById($id);
        $this->verifyToken();
        $this->sendOutput(json_encode($resultData), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }

    public function getAllClients()
    {
        // header('Access-Control-Allow-Origin: http://localhost:4200');
        // header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        // header("Access-Control-Allow-Headers: Content-Type, Authorization, Accept, Accept-Language, X-Authorization");

        $clientModel = new Client(new DataBase);
        $resultData = $clientModel->getAllClients();
        $this->verifyToken();
        $this->sendOutput(json_encode($resultData), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }

    public function getClientByName($name)
    {
        $clientModel = new Client(new DataBase);
        $encondeParamUrl = urldecode($name);
        $this->verifyToken();
        $resultData = $clientModel->getClientByNameCompany($encondeParamUrl);
        $this->sendOutput(json_encode($resultData), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }

    public function deleteClient($id)
    {
        $clientModel = new Client(new DataBase);
        $this->verifyToken();
        try {
            if ($clientModel->deleteClient($id)) {
                $this->sendOutput('Se ha eliminado con Exito', array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
            }
        } catch (Error $e) {
            $this->sendOutput($e->getMessage(), array('HTTP/1.1 500 Internal Server Error'));
        }
    }

    public function insertClient()
    {
        $clientModel = new Client(new DataBase);
        $data = json_decode(file_get_contents('php://input'));
        $arrayData = array("nameCompany" => $data->nameCompany, "direction" => $data->direction, "province" => $data->province, "country" => $data->country, "cif" => $data->cif, "population" => $data->population, "code_postal" => $data->code_postal);
        $this->verifyToken();
        if ($clientModel->insertClient($arrayData)) {
            $this->sendOutput("Se ha insertado correctamente", array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $strErrorDesc = 'Something went wrong!';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->sendOutput($strErrorDesc, array($strErrorHeader));
        }
    }

    public function updateClient($id)
    {
        $clientModel = new Client(new DataBase);
        $this->verifyToken();

        if (count($_POST)) {
            if ($clientModel->updateClient($_POST, $id)) {
                $this->sendOutput("Se ha actualizado correctamente", array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
            }
        }
        new Client($clientModel->getClientById($id));
    }
}
