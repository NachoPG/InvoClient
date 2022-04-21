<?php

namespace App\Models;

use App\Core\Interfaces\IDataBase;

class Client
{

    private IDatabase $database;
    public function __construct(IDatabase $database)
    {
        $this->database = $database;
    }

    public function getClientById($id)
    {
        $sql = "SELECT * FROM Cliente WHERE Id_Client=$id";
        $result = $this->database->executeSQL($sql);
        return array_shift($result);
    }

    public function getAllClients()
    {
        $sql = "SELECT * FROM Cliente";
        return $this->database->executeSQL($sql);
    }

    public function deleteClient($id)
    {
        $sql = "DELETE FROM Cliente WHERE Id_Client=$id";
        return $this->database->actionSQL($sql);
    }

    public function insertClient($data)
    {
        $nameCompany = $this->database->escape($data["nameCompany"]);
        $direction = $this->database->escape($data["direction"]);
        $provincia = $this->database->escape($data["provincia"]);
        $country = $this->database->escape($data["country"]);
        $cif = $this->database->escape($data["cif"]);
        $poblacion = $this->database->escape($data["poblacion"]);
        $code_postal = $this->database->escape($data["code_postal"]);

        $sql = "INSERT INTO cliente (Razon_social,Direccion,Provincia,Pais,Cif,Poblacion,Codigo_Postal) VALUES ('" . $nameCompany . "','" . $direction . "','" . $provincia . "','" . $country . "','" . $cif . "','" . $poblacion . "'," . $code_postal . ")";
        return $this->database->actionSQL($sql);
    }

    public function updateClient($data, $id)
    {
        $nameCompany = $this->database->escape($data["nameCompany"]);
        $direction = $this->database->escape($data["direction"]);
        $provincia = $this->database->escape($data["provincia"]);
        $country = $this->database->escape($data["country"]);
        $cif = $this->database->escape($data["cif"]);
        $poblacion = $this->database->escape($data["poblacion"]);
        $code_postal = $this->database->escape($data["code_postal"]);

        $sql = "UPDATE cliente SET Razon_Social=$nameCompany,Direccion=$direction,Provincia=$provincia,Pais=$country,Cif=$cif,Poblacion=$poblacion,Codigo_Postal=$code_postal WHERE Id_Cliente=$id";
        return $this->database->actionSQL($sql);
    }
}
