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
        $sql = "SELECT * FROM Client WHERE id_client=$id";
        $result = $this->database->executeSQL($sql);
        return array_shift($result);
    }

    public function getAllClients()
    {
        $sql = "SELECT * FROM Client";
        return $this->database->executeSQL($sql);
    }

    public function deleteClient($id)
    {
    }

    public function insertClient($data)
    {
    }

    public function updateClient($data)
    {
    }
}
