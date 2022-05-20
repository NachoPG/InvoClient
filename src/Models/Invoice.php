<?php

namespace App\Models;

use App\Core\Interfaces\IDataBase;
use DateTime;

class Invoice
{

    private IDatabase $database;
    public function __construct(IDatabase $database)
    {
        $this->database = $database;
    }

    public function getInvoicesFromClient($idClient)
    {
        $sql = "SELECT `idInvoice`,`nameArticle`,`price_unit`,`price_total`,`description`,`amount`,`order_date` FROM factura WHERE `Cliente_Id`=$idClient";
        return $this->database->executeSQL($sql);
    }

    public function deleteInvoice($id)
    {
        $sql = "DELETE FROM factura WHERE idInvoice=$id";
        return $this->database->actionSQL($sql);
    }

    public function insertNewInvoice($data)
    {
        $name_article = $this->database->escape($data["nameArticle"]);
        $description = $this->database->escape($data["description"]);
        $price_unit = intval($data["price_unit"]);
        $price_total = intval($data["price_total"]);
        $amount = intval($data["amount"]);
        $orderDate = strtotime($data["order_date"]);

        $sql = "INSERT INTO factura (`nameArticle`,`price_unit`,`price_total`,`description`,`amount`,`order_date`,`Cliente_Id`) VALUES ('" . $name_article . "'," . $price_unit . "," . $price_total . ",'" . $description . "'," . $amount . ",'" . date("Y-m-d", $orderDate) . "'," . $data["clientId"] . ")";
        return $this->database->actionSQL($sql);
    }

    public function updateInvoice($data)
    {
        $name_article = $this->database->escape($data["nameArticle"]);
        $description = $this->database->escape($data["description"]);
        $price_unit = intval($data["price_unit"]);
        $price_total = intval($data["price_total"]);
        $amount = intval($data["amount"]);
        $orderDate = strtotime($data["order_date"]);
        $idInvoice = $data["idInvoice"];

        $sql = "UPDATE factura SET `nameArticle`='$name_article',`price_unit`=$price_unit,`price_total`=$price_total,`description`='$description',`amount`=$amount,`order_date`='" . date("Y-m-d", $orderDate) . "' WHERE `idInvoice`=$idInvoice";
        return $this->database->actionSQL($sql);
    }
}
