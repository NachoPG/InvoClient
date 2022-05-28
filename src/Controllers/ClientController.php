<?php

namespace App\Controllers;

use App\Models\Client;
use App\Core\DataBase;
use Error;
use Exception;

class ClientController extends BaseController
{


    public function getClientId($id)
    {
        $clientModel = new Client(new DataBase);
        $this->verifyToken();
        try {
            $resultData = $clientModel->getClientById($id);
            $this->sendOutput(json_encode(mb_convert_encoding($resultData, "UTF-8", "UTF-8")), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } catch (Exception $e) {
            $strErrorDesc = 'Error:' + $e->getMessage();
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
        }
    }

    public function getAllClients()
    {
        // header('Access-Control-Allow-Origin: http://localhost:4200');
        // header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        // header("Access-Control-Allow-Headers: Content-Type, Authorization, Accept, Accept-Language, X-Authorization");

        $clientModel = new Client(new DataBase);
        $this->verifyToken();
        $resultData = $clientModel->getAllClients();
        try {
            $this->sendOutput(json_encode(mb_convert_encoding($resultData, "UTF-8", "UTF-8")), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } catch (Exception $e) {
            $strErrorDesc = 'Error:' + $e->getMessage();
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
        }
    }

    public function getClientByName($name)
    {
        $clientModel = new Client(new DataBase);
        $encondeParamUrl = urldecode($name);
        $this->verifyToken();
        try {
            $resultData = $clientModel->getClientByNameCompany($encondeParamUrl);
            $this->sendOutput(json_encode(mb_convert_encoding($resultData, "UTF-8", "UTF-8")), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } catch (Exception $e) {
            $strErrorDesc = 'Error:' + $e->getMessage();
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
        }
    }

    public function deleteClient($id)
    {
        $clientModel = new Client(new DataBase);
        $this->verifyToken();
        try {
            if ($clientModel->deleteClient($id)) {
                $this->sendOutput(json_encode(array("message" => "Se ha eliminado con Exito")), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
            } else {
                $strErrorDesc = 'No se ha podido eliminar el cliente. Intentelo de nuevo mas tarde';
                $strErrorHeader = 'HTTP/1.1 404 Internal Server Error';
                $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
            }
        } catch (Error $e) {
            $this->sendOutput(json_encode(array("message" => $e->getMessage())), array('HTTP/1.1 500 Internal Server Error'));
        }
    }

    public function insertClient()
    {
        $clientModel = new Client(new DataBase);
        $data = json_decode(file_get_contents('php://input'));
        $arrayData = array("nameCompany" => $data->nameCompany, "direction" => $data->direction, "phone" => $data->phone, "email" => $data->email, "province" => $data->province, "country" => $data->country, "cif" => $data->cif, "population" => $data->population, "code_postal" => $data->codePostal);
        $this->verifyToken();
        $responseCheckNameClient = $clientModel->checkNameClient($data->nameCompany);

        if ($responseCheckNameClient !== null) {
            $strErrorDesc = 'Ya existe un cliente con el nombre introducido!';
            $strErrorHeader = 'HTTP/1.1 404 Internal Server Error';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
            return;
        }
        if ($clientModel->insertClient($arrayData)) {
            $this->sendOutput(json_encode(array("message" => "Se ha insertado correctamente")), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $strErrorDesc = 'Something went wrong!';
            $strErrorHeader = 'HTTP/1.1 404 Internal Server Error';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
        }
    }

    public function updateClient($id)
    {
        $clientModel = new Client(new DataBase);
        $data = json_decode(file_get_contents('php://input'));
        $arrayData = array("nameCompany" => $data->nameCompany, "direction" => $data->direction, "phone" => $data->phone, "email" => $data->email, "province" => $data->province, "country" => $data->country, "cif" => $data->cif, "population" => $data->population, "code_postal" => $data->codePostal);
        $this->verifyToken();
        $response = $clientModel->checkNameClient($data->nameCompany);


        if ($response !== null && $response["nameCompany"] !== $data->nameCompany) {
            $strErrorDesc = 'Ya existe un cliente con el nombre introducido!';
            $strErrorHeader = 'HTTP/1.1 404 Internal Server Error';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
            return;
        }



        if ($clientModel->updateClient($arrayData, $id)) {
            $this->sendOutput(json_encode(array("message" => "Se ha actualizado con exito")), array('Content-Type: application/json', 'HTTP/1.1 204 NOT_CONTENT'));
        } else {
            $strErrorDesc = 'Error. No se ha podido actualizar el cliente!';
            $strErrorHeader = 'HTTP/1.1 404 Internal Server Error';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
        }
    }
}
