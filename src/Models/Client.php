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
        $sql = "SELECT * FROM cliente WHERE `idClient`=$id";
        return $this->database->executeSQL($sql);
    }

    public function getAllClients()
    {
        $sql = "SELECT * FROM cliente";
        return $this->database->executeSQL($sql);
    }

    public function getClientByNameCompany($nameCompany)
    {
        $sql = "SELECT * FROM cliente WHERE `nameCompany`='$nameCompany'";
        return $this->database->executeSQL($sql);
    }

    public function deleteClient($id)
    {
        $sql = "DELETE FROM Cliente WHERE `idClient`=$id";
        return $this->database->actionSQL($sql);
    }

    public function insertClient($data)
    {
        $nameCompany = $this->database->escape($data["nameCompany"]);
        $direction = $this->database->escape($data["direction"]);
        $provincia = $this->database->escape($data["province"]);
        $country = $this->database->escape($data["country"]);
        $cif = $this->database->escape($data["cif"]);
        $poblacion = $this->database->escape($data["population"]);
        $code_postal = intval($data["code_postal"]);
        $phone = $this->database->escape($data["phone"]);
        $email = $this->database->escape($data["email"]);


        $sql = "INSERT INTO cliente (`nameCompany`,`direction`,`province`,`country`,`cif`,`population`,`codePostal`,`phone`,`email`) VALUES ('" . $nameCompany . "','" . $direction . "','" . $provincia . "','" . $country . "','" . $cif . "','" . $poblacion . "'," . $code_postal . ",'" . $phone . "','" . $email . "')";
        return $this->database->actionSQL($sql);
    }

    public function updateClient($data, $id)
    {
        $nameCompany = $this->database->escape($data["nameCompany"]);
        $direction = $this->database->escape($data["direction"]);
        $provincia = $this->database->escape($data["province"]);
        $country = $this->database->escape($data["country"]);
        $cif = $this->database->escape($data["cif"]);
        $poblacion = $this->database->escape($data["population"]);
        $code_postal = intval($data["code_postal"]);
        $phone = $this->database->escape($data["phone"]);
        $email = $this->database->escape($data["email"]);

        $sql = "UPDATE cliente SET `nameCompany`='$nameCompany',`direction`='$direction',`phone`='$phone',`email`='$email',`province`='$provincia',country='$country',`cif`='$cif',`population`='$poblacion',`codePostal`=$code_postal WHERE `idClient`=$id";
        return $this->database->actionSQL($sql);
    }

    public function checkNameClient($nameCompany)
    {
        $nameCompany = $this->database->escape($nameCompany);
        $sql = "SELECT `nameCompany` FROM cliente WHERE `nameCompany`='$nameCompany'";
        $result = $this->database->executeSQL($sql);
        return array_shift($result);
    }
}
