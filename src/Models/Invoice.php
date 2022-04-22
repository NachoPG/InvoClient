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
        $sql = "SELECT * FROM factura WHERE Cliente_Id=$idClient";
        return $this->database->executeSQL($sql);
    }

    public function deleteInvoice($id)
    {
        $sql = "DELETE FROM factura WHERE Id_Factura=$id";
        return $this->database->actionSQL($sql);
    }

    public function insertNewInvoice($data)
    {
        $name_article = $this->database->escape($data["name_article"]);
        $description = $this->database->escape($data["description"]);
        $dateFactura = new DateTime("now");
        $sql = "INSERT FROM factura (Nombre_art,Unidades,Precio_Unidad,Importe Total,Descripcion,Cantidad,Fecha_Pedido,Cliente_Id) VALUES ('" . $name_article . "'," . $data["unidades"] . "," . $data["precio"] . "," . $data["importe_total"] . "," . $data["cantidad"] . ",'" . $description . "'," . $dateFactura . "," . $data["cliente_id"] . ")";
        return $this->database->actionSQL($sql);
    }

    public function updateInvoice($id, $data)
    {
        $name_article = $this->database->escape($data["name_article"]);
        $description = $this->database->escape($data["description"]);

        $sql = "UPDATE factura SET Nombre_art=$name_article,Unidades=" . $data["unidades"] . ",Precio_Unidad=" . $data["price"] . ",Importe_Total=" . $data["importe"] . ",Descripcion=$description,Cantidad=" . $data["cantidad"] . ",Cliente_Id=" . $data["cliente_id"] . "WHERE Id_Factura=$id";
        return $this->database->actionSQL($sql);
    }
}
