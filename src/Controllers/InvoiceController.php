<?php

namespace App\Controllers;

use App\Models\Invoice;
use App\Core\DataBase;
use Exception;

class InvoiceController extends BaseController
{

    public function getInvoicesById($id)
    {
        $invoiceModel = new Invoice(new DataBase);
        $this->verifyToken();
        try {
            $resultData = $invoiceModel->getInvoicesFromClient($id);
            $this->sendOutput(json_encode(mb_convert_encoding($resultData, "UTF-8", "UTF-8")), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } catch (Exception $e) {
            $strErrorDesc = 'Error:' + $e->getMessage();
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
        }
    }

    public function insertInvoiceFromClient()
    {
        $invoiceModel = new Invoice(new DataBase);
        $data = json_decode(file_get_contents('php://input'));
        $arrayData = array("nameArticle" => $data->nameArticle, "price_unit" => $data->price_unit, "price_total" => $data->price_total, "description" => $data->description, "amount" => $data->amount, "order_date" => $data->order_date, "clientId" => $data->idClient);
        $this->verifyToken();
        if ($invoiceModel->insertNewInvoice($arrayData)) {
            $this->sendOutput(json_encode(array("message" => "Se ha insertado correctamente")), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $strErrorDesc = 'Something went wrong!';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
        }
    }

    public function updateInvoiceFromClient()
    {
        $invoiceModel = new Invoice(new DataBase);
        $data = json_decode(file_get_contents('php://input'));
        $arrayData = array("idInvoice" => $data->idInvoice, "nameArticle" => $data->nameArticle, "price_unit" => $data->price_unit, "price_total" => $data->price_total, "description" => $data->description, "amount" => $data->amount, "order_date" => $data->order_date);
        $this->verifyToken();
        if ($invoiceModel->updateInvoice($arrayData)) {
            $this->sendOutput(json_encode(array("message" => "Se ha modificado correctamente")), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $strErrorDesc = 'Something went wrong!';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
        }
    }

    public function deleteInvoiceFromClient($id)
    {
        $invoiceModel = new Invoice(new DataBase);
        $this->verifyToken();
        try {
            $invoiceModel->deleteInvoice($id);
            $this->sendOutput(json_encode(array("message" => "Se ha eliminado correctamente")), array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } catch (Exception $e) {
            $strErrorDesc = 'Error:' + $e->getMessage();
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            $this->sendOutput(json_encode(array("message" => $strErrorDesc)), array($strErrorHeader));
        }
    }
}
