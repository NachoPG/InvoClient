<?php

namespace App\Controllers;

use App\Models\Client;
use App\Core\DataBase;
use App\Core\Request;
use Error;

class ClientController extends BaseController
{

    public function getClientId($id)
    {
        $clientModel = new Client(new DataBase);
        $resultData = $clientModel->getClientById($id);
        //Comprobacion de datos 
        $this->sendOutput(json_encode($resultData), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }

    public function getAllClients()
    {
        $clientModel = new Client(new DataBase);
        $resultData = $clientModel->getAllClients();
        $this->sendOutput(json_encode($resultData), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }

    public function getClientByName($name)
    {
        $encondeParamUrl = urldecode($name);
        $clientModel = new Client(new DataBase);
        $resultData = $clientModel->getClientByNameCompany($encondeParamUrl);
        $this->sendOutput(json_encode($resultData), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }

    public function deleteClient($id)
    {
        $clientModel = new Client(new DataBase);
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
        if ($clientModel->insertClient($arrayData)) {
            $this->sendOutput("Se ha insertado correctamente", array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $strErrorDesc = 'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->sendOutput($strErrorDesc, array($strErrorHeader));
        }
    }
}
